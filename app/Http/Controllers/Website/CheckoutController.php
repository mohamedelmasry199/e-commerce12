<?php

namespace App\Http\Controllers\Website;

use App\Actions\Checkout\ResolveCheckoutSessionAction;
use App\Actions\Payments\VerifyPaymentAction;
use App\DTOs\CheckoutData;
use App\Exceptions\Checkout\EmptyCartException;
use App\Exceptions\Checkout\OutOfStockException;
use App\Exceptions\Checkout\PaymentException;
use App\Exceptions\Checkout\ProductUnavailableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Services\Website\CheckoutService;
use App\Services\Website\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService,
        protected CouponService $couponService,
    ) {}
    public function showCheckoutPage(){
        $cart = Cart::where('user_id', auth()->id())->first()->with('items.product')->get();
          $idempotencyKey = ResolveCheckoutSessionAction::generateKey();
        session(['checkout_idempotency_key' => $idempotencyKey]);
        return view('website.checkout', compact('cart', 'idempotencyKey'));
    }
    public function checkout(){
        //1-get total price of the cart items +shipping price - discount if there is a coupon
        //2- send order data to myfatoorah and get payment url
        //3- redirect user to payment url
        //4-create order and transaction records in database with pending status
    }
        // ──────────────────────────────────────────────────────────────────
    // STEP 2 — Process checkout → create order → redirect to payment
    // ──────────────────────────────────────────────────────────────────

    public function process( CheckoutRequest $request)
    {
        $user = auth()->user();
         // ── Retrieve the idempotency key ─────────────────────────────
        // Read from the session — not from $request to prevent tampering
        // (user cannot forge a key from a previous checkout to get the same order)
        $idempotencyKey = session('checkout_idempotency_key');
        if (! $idempotencyKey) {
            // Key missing — user probably navigated directly to POST
            // Redirect them back to checkout page to generate a fresh key
            return redirect()->route('checkout.index')
                ->with('error', __('checkout.session_expired'));
        }
        $data_needed =[
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->user_email,
            'phone' => $request->user_phone,
            'country' => $this->checkoutService->getNameFromId(\App\Models\Country::class , $request->country_id),
            'governorate' => $this->checkoutService->getNameFromId(\App\Models\Governorate::class , $request->governorate_id),
            'city' => $this->checkoutService->getNameFromId(\App\Models\City::class , $request->city_id),
            'street' => $request->street,
            'note' => $request->note,
            'couponCode' => $user->cart->coupon,
            'governorate_id' => $request->governorate_id,
        ];
        $data = CheckoutData::fromArray($data_needed);

        try {
            $result = $this->checkoutService->checkout($user, $data, $idempotencyKey);

            // If price drifted, flash a notice — user still proceeds
           if ($result['priceChanged'] && ! $result['reused']) {
                session()->flash('warning', __('checkout.price_updated'));
            }

            // Redirect user to payment gateway page
            return redirect()->away($result['paymentResult']->redirectUrl);

        } catch (EmptyCartException $e) {
            return redirect()->route('website.cart')
                ->with('error', __('checkout.empty_cart'));

        } catch (OutOfStockException $e) {
            return back()->with('error', $e->getMessage());

        } catch (ProductUnavailableException $e) {
            return back()->with('error', $e->getMessage());

        } catch (PaymentException $e) {
            Log::error('CheckoutController: payment initiation failed', [
                'user_id' => $user->id,
                'idempotency_key'  => $idempotencyKey,
                'error'   => $e->getMessage(),
            ]);
            return back()->with('error', __('checkout.payment_initiation_failed'));

        } catch (\Throwable $e) {
            Log::error('CheckoutController: unexpected error', [
                'user_id' => $user->id,
                'idempotency_key'  => $idempotencyKey,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return back()->with('error', __('checkout.unexpected_error'));
        }
    }

    // ──────────────────────────────────────────────────────────────────
    // STEP 3a — Payment gateway redirects user back (browser callback)
    //
    // NOTE: This is NOT the primary payment confirmation.
    //       The webhook is. This just gives the user a nice redirect.
    //       We still verify here to handle cases where webhook is slow.
    // ──────────────────────────────────────────────────────────────────


    public function callback(Request $request)
    {
        try {
            $result = app(VerifyPaymentAction::class)
                ->execute($request->all(), config('payment.default'));

            if ($result->success) {
                // Clear the idempotency key from session — checkout is done
                session()->forget('checkout_idempotency_key');

                return redirect()->route('checkout.success', ['order' => $result->orderId])
                    ->with('success', __('checkout.payment_success'));
            }

            return redirect()->route('checkout.failed', ['order' => $result->orderId])
                ->with('error', __('checkout.payment_failed'));

        } catch (\Throwable $e) {
            Log::error('Checkout callback error', ['error' => $e->getMessage()]);
            return redirect()->route('checkout.failed')
                ->with('error', __('checkout.unexpected_error'));
        }
    }

    // ──────────────────────────────────────────────────────────────────
    // STEP 3b — Payment failed
    // ──────────────────────────────────────────────────────────────────

    public function failed(Request $request)
    {
        $order = null;

        if ($request->has('order')) {
            $order = Order::where('id', $request->order)
                ->where('user_id', auth()->id())
                ->first();

            if ($order && $order->status === 'pending') {
                $this->checkoutService->cancelOrder($order);
                // Note: cancelOrder calls markSessionFailed internally
                // so the session is marked failed here
            }
        }

        // Clear the idempotency key — user must start a fresh checkout
        session()->forget('checkout_idempotency_key');

        return view('checkout.failed', compact('order'));
    }

    // ──────────────────────────────────────────────────────────────────
    // STEP 4 — Success page
    // ──────────────────────────────────────────────────────────────────

    public function success(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['items.product.images', 'transaction']);

        return view('checkout.success', compact('order'));
    }

    // ──────────────────────────────────────────────────────────────────
    // Coupon AJAX validation (called before form submission)
    // ──────────────────────────────────────────────────────────────────

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon' => 'required|string|max:50']);

        $result = $this->couponService->validate(auth()->user(), $request->coupon);

        return response()->json($result, $result['valid'] ? 200 : 422);
    }

}
