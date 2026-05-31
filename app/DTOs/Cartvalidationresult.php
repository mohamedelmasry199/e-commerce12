<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

/**
 * Holds the validated, server-recalculated cart snapshot.
 * Frontend totals are NEVER trusted — these are the real numbers.
 */
class CartValidationResult
{
    public function __construct(
        /** Cart items with product & variant loaded */
        public readonly Collection $items,

        /** Backend-recalculated subtotal (sum of item price × qty) */
        public readonly float $subtotal,

        /** Coupon applied or null */
        public readonly ?object $coupon,

        /** Discount amount in currency units */
        public readonly float $discount,

        /** Shipping cost from config */
        public readonly float $shippingPrice,

        /** Final amount the customer pays */
        public readonly float $total,

        /** Whether any item's price changed since it was added to cart */
        public readonly bool $priceChanged,
    ) {}
}
