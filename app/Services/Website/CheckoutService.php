<?php

namespace App\Services;

use App\Actions\Checkout\CreatePendingOrderAction;
use App\Actions\Checkout\GetValidatedCartAction;
use App\Actions\Checkout\ResolveCheckoutSessionAction;
use App\Actions\Inventory\ReleaseInventoryAction;
use App\Actions\Inventory\ReserveInventoryAction;
use App\DTOs\CheckoutData;
use App\DTOs\PaymentResult;
use App\Enums\OrderStatus;
use App\Models\CheckoutSession;
use App\Models\Order;
use App\Models\User;
use App\Services\Payments\PaymentManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutService
{
    public function __construct(
        protected GetValidatedCartAction       $validateCartAction,
        protected CreatePendingOrderAction     $createOrderAction,
        protected ReserveInventoryAction       $reserveInventoryAction,
        protected ResolveCheckoutSessionAction $resolveSessionAction,
        protected PaymentManager               $paymentManager,
    ) {}

    /**
     * Main checkout method — fully idempotent.
     *
     * Flow:
     * ─────
     * 1. Resolve the CheckoutSession using the idempotency key
     *    → If a valid session with an order already exists: skip steps 2-4
     *    → If new session: run the full pipeline
     *
     * 2. Validate cart (prices, stock, coupon)
     * 3. Create pending order + reserve inventory (one DB transaction)
     * 4. Link the order to the CheckoutSession
     * 5. Call payment gateway → get redirect URL
     *
     * If steps 2-4 succeed but step 5 (gateway call) times out:
     *   → User retries with the SAME idempotency key
     *   → Step 1 finds the existing session with the existing order
     *   → We skip directly to step 5 with the same order
     *   → No duplicate order, no duplicate stock reservation
     */
    public function checkout(User $user, CheckoutData $data, string $idempotencyKey): array
    {
        // ── Step 1: Resolve session (idempotency guard) ──────────────
        $session = $this->resolveSessionAction->execute($user, $idempotencyKey);

        // ── Step 2: Session already has an order? ────────────────────
        // This handles the case: order was created, then gateway timed out,
        // user retried — we reuse the same order.
        if ($session->hasOrder()) {
            $order = $session->order()->with('items')->first();

            // Order is still pending — just re-initiate payment
            if ($order && $order->status === OrderStatus::PENDING->value) {
                Log::info('CheckoutService: reusing existing order for session', [
                    'session_id'       => $session->id,
                    'idempotency_key'  => $idempotencyKey,
                    'order_id'         => $order->id,
                ]);

                $gateway       = $this->paymentManager->defaultDriver();
                $paymentResult = $gateway->pay($order);

                return [
                    'paymentResult' => $paymentResult,
                    'order'         => $order,
                    'priceChanged'  => false,
                    'reused'        => true, // flag so controller knows
                ];
            }
        }

        // ── Step 3: Fresh checkout — validate cart ───────────────────
        $cartResult = $this->validateCartAction->execute($user, $data->couponCode,$data->governorate_id);

        // ── Step 4: Create order + reserve stock in one transaction ──
        $order = DB::transaction(function () use ($user, $cartResult, $data, $session) {

            $order = $this->createOrderAction->execute($user, $cartResult, $data);

            $this->reserveInventoryAction->execute($order);

            // Link the order to the checkout session
            // This is the key step — now retries will find this order
            $session->update([
                'order_id'      => $order->id,
                'cart_snapshot' => $cartResult->items->map(fn ($i) => [
                    'product_id'  => $i->product_id,
                    'variant_id'  => $i->product_variant_id,
                    'quantity'    => $i->quantity,
                    'price'       => $i->price,
                ])->toArray(),
            ]);

            return $order;
        });

        Log::info('CheckoutService: new order created', [
            'session_id'      => $session->id,
            'idempotency_key' => $idempotencyKey,
            'order_id'        => $order->id,
        ]);

        // ── Step 5: Initiate payment (outside transaction) ───────────
        $gateway       = $this->paymentManager->defaultDriver();
        $paymentResult = $gateway->pay($order);

        return [
            'paymentResult' => $paymentResult,
            'cartResult'    => $cartResult,
            'order'         => $order,
            'priceChanged'  => $cartResult->priceChanged,
            'reused'        => false,
        ];
    }

    /**
     * Mark the checkout session as paid.
     * Called by ConfirmOrderAction after payment verification.
     */
    public function markSessionPaid(Order $order): void
    {
        CheckoutSession::where('order_id', $order->id)
            ->pending()
            ->update(['status' => 'paid']);
    }

    /**
     * Mark the checkout session as failed.
     * Called when payment explicitly fails.
     */
    public function markSessionFailed(Order $order): void
    {
        CheckoutSession::where('order_id', $order->id)
            ->pending()
            ->update(['status' => 'failed']);
    }

    /**
     * Cancel a pending order and restore reserved stock.
     */
    public function cancelOrder(Order $order): void
    {
        if ($order->status !== OrderStatus::PENDING->value) {
            return;
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => OrderStatus::CANCELLED->value]);
            app(ReleaseInventoryAction::class)->execute($order);
        });

        $this->markSessionFailed($order);

        Log::info('CheckoutService: order cancelled', ['order_id' => $order->id]);
    }

    public function getNameFromId($model , $id){
        return $model::find($id)->name;
    }
}
