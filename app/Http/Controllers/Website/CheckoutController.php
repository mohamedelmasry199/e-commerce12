<?php

namespace App\Http\Controllers\Website;

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
        return view('website.checkout', compact('cart'));
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
            $result = $this->checkoutService->checkout($user, $data);

            // If price drifted, flash a notice — user still proceeds
            if ($result['priceChanged']) {
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
                'error'   => $e->getMessage(),
            ]);
            return back()->with('error', __('checkout.payment_initiation_failed'));

        } catch (\Throwable $e) {
            Log::error('CheckoutController: unexpected error', [
                'user_id' => $user->id,
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
            $result = app(\App\Actions\Payments\VerifyPaymentAction::class)
                ->execute($request->all(), config('payment.default'));

            if ($result->success) {
                return redirect()->route('website.checkout.success', ['order' => $result->orderId])
                    ->with('success', __('checkout.payment_success'));
            }

            return redirect()->route('website.checkout.failed', ['order' => $result->orderId])
                ->with('error', __('website.checkout.payment_failed'));

        } catch (\Throwable $e) {
            Log::error('Checkout callback error', ['error' => $e->getMessage()]);
            return redirect()->route('website.checkout.failed')
                ->with('error', __('checkout.unexpected_error'));
        }
    }

    // ──────────────────────────────────────────────────────────────────
    // STEP 3b — Payment failed / user cancelled at gateway
    // ──────────────────────────────────────────────────────────────────

    public function failed(Request $request)
    {
        $order = null;

        if ($request->has('order')) {
            $order = Order::where('id', $request->order)
                ->where('user_id', auth()->id())
                ->first();

            // Cancel order and restore stock if it's still pending
            if ($order && $order->status === 'pending') {
                $this->checkoutService->cancelOrder($order);
            }
        }

        return view('website.checkout.failed', compact('order'));
    }

    // ──────────────────────────────────────────────────────────────────
    // STEP 4 — Order success page
    // ──────────────────────────────────────────────────────────────────

    public function success(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['items.product.images', 'transaction']);

        return view('website.checkout.success', compact('order'));
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
