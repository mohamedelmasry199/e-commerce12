<?php

namespace App\Actions\Payments;

use App\Actions\Payments\ConfirmOrderAction;
use App\DTOs\PaymentVerificationResult;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\Payments\PaymentManager;
use Illuminate\Support\Facades\Log;

/**
 * Verifies payment with the gateway and dispatches ConfirmOrderAction.
 *
 * Used by BOTH:
 *  - WebhookController (server-to-server, no session)
 *  - CheckoutController@callback (browser redirect back)
 *
 * Always calls gateway->verify() — NEVER trusts frontend success flag.
 */
class VerifyPaymentAction
{
    public function __construct(
        protected PaymentManager    $paymentManager,
        protected ConfirmOrderAction $confirmOrderAction,
    ) {}

    /**
     * @param  array  $payload  Raw GET/POST data from gateway callback or webhook
     * @param  string $gateway  Gateway slug (e.g. 'myfatoorah')
     * @return PaymentVerificationResult
     */
    public function execute(array $payload, string $gateway): PaymentVerificationResult
    {
        $driver = $this->paymentManager->driver($gateway);
        $result = $driver->verify($payload);

        if (! $result->success) {
            Log::warning('Payment verification failed', [
                'gateway'        => $gateway,
                'transaction_id' => $result->transactionId,
                'message'        => $result->message,
            ]);
            return $result;
        }

        $order = Order::find($result->orderId);

        if (! $order) {
            Log::error('VerifyPaymentAction: order not found', [
                'order_id' => $result->orderId,
                'gateway'  => $gateway,
            ]);
            return new PaymentVerificationResult(
                success:       false,
                transactionId: $result->transactionId,
                orderId:       $result->orderId,
                message:       'Order not found',
            );
        }

        // Guard: only confirm if still pending
        if ($order->status !== OrderStatus::PENDING->value) {
            Log::info('VerifyPaymentAction: order already processed', [
                'order_id' => $order->id,
                'status'   => $order->status,
            ]);
            return $result;
        }

        $this->confirmOrderAction->execute(
            order:         $order,
            gatewayName:   $gateway,
            transactionId: $result->transactionId,
        );

        return $result;
    }
}
