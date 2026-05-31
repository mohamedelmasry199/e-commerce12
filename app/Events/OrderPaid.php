<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired after an order is successfully confirmed as paid.
 *
 * Listeners:
 *  - SendOrderConfirmationEmail
 *  - ClearCartListener
 *  - SendAdminNotificationListener
 *  - ReleaseReservationOnSuccessListener (marks reservation confirmed)
 */
class OrderPaid
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Order $order,
    ) {}
}
