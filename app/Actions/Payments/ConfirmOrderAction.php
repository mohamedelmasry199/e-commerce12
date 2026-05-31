<?php

namespace App\Actions\Payments;

use App\Enums\OrderStatus;
use App\Events\OrderPaid;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

/**
 * Step 5 (post-webhook) of checkout.
 *
 * After the payment gateway confirms success:
 *   1. Mark the order as PAID (idempotent — safe to call multiple times)
 *   2. Create the transaction record
 *   3. Increment coupon usage count
 *   4. Dispatch OrderPaid event (listeners handle email, cart clear, etc.)
 *
 * MUST be called inside a DB::transaction() or wraps its own.
 */
class ConfirmOrderAction
{
    public function execute(
        Order  $order,
        string $gatewayName,
        string $transactionId,
    ): void {
        // Idempotency guard — if already paid (duplicate webhook), skip
        if ($order->status === OrderStatus::PAID->value) {
            return;
        }

        DB::transaction(function () use ($order, $gatewayName, $transactionId) {
            // ── Mark order paid ─────────────────────────────────────
            $order->update(['status' => OrderStatus::PAID->value]);

            // ── Record transaction ──────────────────────────────────
            Transaction::create([
                'user_id'        => $order->user_id,
                'payment_method' => $gatewayName,
                'transaction_id' => $transactionId,
                'order_id'       => $order->id,
            ]);

            // ── Increment coupon usage ──────────────────────────────
            if ($order->coupon) {
                Coupon::where('code', $order->coupon)->increment('time_used');
            }
        });

        // ── Dispatch event (outside transaction — listeners may send emails etc.) ──
        event(new OrderPaid($order->fresh()));
    }
}
