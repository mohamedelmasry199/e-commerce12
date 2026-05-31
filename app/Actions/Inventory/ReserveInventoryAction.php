<?php

namespace App\Actions\Inventory;

use App\Exceptions\Checkout\OutOfStockException;
use App\Models\InventoryReservation;
use App\Models\Order;
use App\Models\ProductVariant;

/**
 * Step 3 of checkout.
 *
 * Uses lockForUpdate() inside the wrapping DB::transaction() to prevent
 * two users simultaneously buying the last unit (race condition protection).
 *
 * Flow per item:
 *   1. Lock the variant row in the DB
 *   2. Re-check stock (race-condition safe)
 *   3. Decrement stock
 *   4. Create an inventory_reservation record that expires in 15 minutes
 *      (the job ReleaseExpiredReservationsJob will restore stock if unpaid)
 *
 * MUST be called inside a DB::transaction().
 */
class ReserveInventoryAction
{
    public function execute(Order $order): void
    {
        foreach ($order->items as $item) {
            $variant = ProductVariant::where('id', $item->product_variant_id)
                ->lockForUpdate()   // ← row-level lock until transaction commits
                ->first();

            if (! $variant) {
                continue; // variant deleted between cart and checkout — should not happen but safe guard
            }

            // Only manage stock if the variant has stock management enabled
            if (! $variant->manage_stock) {
                continue;
            }

            // Re-check stock AFTER acquiring the lock
            if ($variant->stock < $item->product_quantity) {
                throw new OutOfStockException(
                    productName: $item->product_name,
                    available:   $variant->stock,
                    requested:   $item->product_quantity,
                );
            }

            // Decrement stock immediately
            $variant->decrement('stock', $item->product_quantity);

            // Record reservation so we can restore stock if payment never completes
            InventoryReservation::create([
                'order_id'    => $order->id,
                'variant_id'  => $variant->id,
                'quantity'    => $item->product_quantity,
                'expires_at'  => now()->addMinutes(
                    config('payment.reservation_minutes', 15)
                ),
                'released_at' => null,
            ]);
        }
    }
}
