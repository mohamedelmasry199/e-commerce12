<?php

namespace App\DTOs;

/**
 * Result returned from any payment gateway after initiating payment.
 */
class PaymentResult
{
    public function __construct(
        /** URL to redirect the user to complete payment */
        public readonly string $redirectUrl,

        /** Gateway reference ID (e.g. MyFatoorah InvoiceId) */
        public readonly string $gatewayReference,
    ) {}
}
