<?php

namespace App\Services\Website;

use App\Actions\Checkout\CreatePendingOrderAction;
use App\Actions\Checkout\GetValidatedCartAction;
use App\Actions\Inventory\ReserveInventoryAction;
use App\DTOs\CartValidationResult;
use App\DTOs\CheckoutData;
use App\DTOs\PaymentResult;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\Services\Payments\PaymentManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Orchestrates the full checkout pipeline.
 *
 * Called by CheckoutController and wrapped in a single DB transaction.
 *
 * Steps:
 *  1. Validate cart (stock, price, product availability)
 *  2. Create pending order + order items
 *  3. Reserve / decrement inventory (row-locked)
 *  4. Initiate payment with the configured gateway
 *
 * If any step throws, the transaction rolls back:
 *  - No order is created
 *  - No stock is decremented
 *  - User gets a clean error message
 */
class CheckoutService
{
    public function __construct(
        protected GetValidatedCartAction  $validateCartAction,
        protected CreatePendingOrderAction $createOrderAction,
        protected ReserveInventoryAction   $reserveInventoryAction,
        protected PaymentManager           $paymentManager,
    ) {}

    /**
     * Run the full checkout flow.
     *
     * @return array{
     *     paymentResult: PaymentResult,
     *     cartResult: CartValidationResult,
     *     order: Order,
     *     priceChanged: bool
     * }
     */
    public function checkout(User $user, CheckoutData $data): array
    {
        // ── Step 1: Validate cart (outside transaction — read-only) ── get items ,all prices , discount ,coupon data and price changed flag
        $cartResult = $this->validateCartAction->execute($user, $data->couponCode,$data->governorate_id);

        // ── Steps 2–3: Create order + reserve stock in one transaction ──
        $order = DB::transaction(function () use ($user, $cartResult, $data) {
            $order = $this->createOrderAction->execute($user, $cartResult, $data);
            $this->reserveInventoryAction->execute($order);
            return $order;
        });

        Log::info('Checkout: pending order created', [
            'order_id' => $order->id,
            'user_id'  => $user->id,
            'total'    => $order->total_price,
        ]);

        // ── Step 4: Initiate payment (outside transaction — HTTP call) ──
        $gateway       = $this->paymentManager->defaultDriver();
        $paymentResult = $gateway->pay($order);

        return [
            'paymentResult' => $paymentResult,
            'cartResult'    => $cartResult,
            'order'         => $order,
            'priceChanged'  => $cartResult->priceChanged,
        ];
    }

    /**
     * Cancel a pending order and restore reserved stock.
     * Used when payment explicitly fails (not just a timeout).
     */
    public function cancelOrder(Order $order): void
    {
        if ($order->status !== OrderStatus::PENDING->value) {
            return;
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => OrderStatus::CANCELLED->value]);
            app(\App\Actions\Inventory\ReleaseInventoryAction::class)->execute($order);
        });

        Log::info('Checkout: order cancelled', ['order_id' => $order->id]);
    }
    public function getNameFromId($model , $id){
        return $model::find($id)->name;
    }
}
