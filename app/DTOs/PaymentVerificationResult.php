<?php

namespace App\DTOs;

/**
 * Result returned from any payment gateway after verifying a callback/webhook.
 */
class PaymentVerificationResult
{
    public function __construct(
        public readonly bool   $success,
        public readonly string $transactionId,
        public readonly int    $orderId,
        public readonly string $message,
    ) {}
}
