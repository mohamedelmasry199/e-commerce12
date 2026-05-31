<?php

namespace App\Contracts;

use App\DTOs\PaymentResult;
use App\DTOs\PaymentVerificationResult;
use App\Models\Order;

/**
 * Every payment gateway MUST implement this interface.
 * Adding a new gateway = implement this + register in PaymentManager.
 */
interface PaymentGateway
{
    /**
     * Initiate payment for the given order.
     * Returns a DTO with the redirect URL and gateway reference.
     */
    public function pay(Order $order): PaymentResult;

    /**
     * Verify a callback or webhook payload from the gateway.
     * Returns a DTO with success status, transaction ID, and the order ID
     * we stored in the gateway's user-defined field.
     */
    public function verify(array $payload): PaymentVerificationResult;

    /**
     * The unique slug stored in transactions.payment_method.
     */
    public function name(): string;
}
