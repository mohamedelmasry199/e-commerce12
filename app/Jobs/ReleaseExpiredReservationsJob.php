<?php

namespace App\Jobs;

use App\Actions\Inventory\ReleaseInventoryAction;
use App\Enums\OrderStatus;
use App\Models\InventoryReservation;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

/**
 * Runs every minute via the scheduler.
 *
 * Finds inventory reservations that:
 *  - Have expired (expires_at < now)
 *  - Have not been released yet (released_at IS NULL)
 *  - Belong to an order that is still PENDING (not paid)
 *
 * Then:
 *  - Restores the reserved stock back to the variant
 *  - Marks the order as CANCELLED
 *  - Marks the reservation as released
 *
 * This prevents stock being stuck "locked" if the user:
 *  - Closed the browser before paying
 *  - Had a payment timeout
 *  - Was redirected away and never completed
 */
class ReleaseExpiredReservationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function handle(ReleaseInventoryAction $releaseInventoryAction): void
    {
        // Find orders with expired, unreleased reservations that are still pending
        $orderIds = InventoryReservation::query()
            ->whereNull('released_at')
            ->where('expires_at', '<', now())
            ->pluck('order_id')
            ->unique();


        $pendingOrders = Order::whereIn('id', $orderIds)
            ->where('status', OrderStatus::PENDING->value)
            ->get();

        foreach ($pendingOrders as $order) {
            try {
                $releaseInventoryAction->execute($order);

                $order->update(['status' => OrderStatus::CANCELLED->value]);

                Log::info('ReleaseExpiredReservationsJob: order cancelled + stock restored', [
                    'order_id' => $order->id,
                ]);
            } catch (\Throwable $e) {
                Log::error('ReleaseExpiredReservationsJob: failed for order', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
            }
        }
    }
}
