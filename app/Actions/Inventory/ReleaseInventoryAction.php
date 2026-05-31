<?php

namespace App\Actions\Inventory;

use App\Models\InventoryReservation;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

/**
 * Restores reserved stock back to variants.
 *
 * Called by:
 *  - ReleaseExpiredReservationsJob (cron, every minute)
 *  - ConfirmOrderAction if payment fails
 */
class ReleaseInventoryAction
{
    public function execute(Order $order): void
    {
        $reservations = InventoryReservation::where('order_id', $order->id)
            ->whereNull('released_at')
            ->get();

        foreach ($reservations as $reservation) {
            DB::transaction(function () use ($reservation) {
                // Restore stock to the variant
                $reservation->variant()->increment('stock', $reservation->quantity);

                // Mark the reservation as released
                $reservation->update(['released_at' => now()]);
            });
        }
    }
}
