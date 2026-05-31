<?php

namespace App\Exceptions\Checkout;

use RuntimeException;

/** Thrown when a product in the cart is inactive or deleted */
class ProductUnavailableException extends RuntimeException
{
    public function __construct(string $productName)
    {
        parent::__construct("'{$productName}' is no longer available.");
    }
}
