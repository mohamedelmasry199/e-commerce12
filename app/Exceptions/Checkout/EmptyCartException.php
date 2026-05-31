<?php

namespace App\Exceptions\Checkout;

use RuntimeException;

class EmptyCartException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Cannot checkout with an empty cart.');
    }
}
