<?php

namespace App\Exceptions\Checkout;

use RuntimeException;

/** Thrown when a cart item's variant has insufficient stock */
class OutOfStockException extends RuntimeException
{
    public function __construct(
        public readonly string $productName,
        public readonly int    $available,
        public readonly int    $requested,
    ) {
        parent::__construct(
            "'{$productName}' only has {$available} units available (requested {$requested})."
        );
    }
}
