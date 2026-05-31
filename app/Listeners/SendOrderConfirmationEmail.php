<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Sends order confirmation email to the customer after payment.
 * Queued so it doesn't block the webhook response.
 */
class SendOrderConfirmationEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'emails';

    public function handle(OrderPaid $event): void
    {
        $order = $event->order->load('items.product.images');

        try {
            Mail::to($order->user_email)
                ->send(new \App\Mail\OrderConfirmationMail($order));

            Log::info('Order confirmation email sent', [
                'order_id' => $order->id,
                'email'    => $order->user_email,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send order confirmation email', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }
}
