<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Clears the user's cart after order is paid.
 * Queued to keep the webhook response fast.
 *
 * Note: cart items may already be empty if the user checked out in the same
 * session, but we run this defensively to ensure consistency.
 */
class ClearCartListener implements ShouldQueue
{
    public function handle(OrderPaid $event): void
    {
        $cart = Cart::where('user_id', $event->order->user_id)->first();

        if ($cart) {
            $cart->items()->delete();
        }
    }
}
