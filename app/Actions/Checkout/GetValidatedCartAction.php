<?php

namespace App\Actions\Checkout;

use App\DTOs\CartValidationResult;
use App\Exceptions\Checkout\EmptyCartException;
use App\Exceptions\Checkout\OutOfStockException;
use App\Exceptions\Checkout\ProductUnavailableException;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Governorate;
use App\Models\User;

/**
 * Step 1 of checkout.
 *
 * Validates every cart item against the current DB state:
 *   - product still exists and is active
 *   - variant still exists
 *   - enough stock is available
 *   - recalculates price from the variant (never trusts cart.price)
 *   - detects price drift and sets priceChanged flag
 *   - validates and applies coupon
 *   - recalculates subtotal / discount / shipping / total
 */
class GetValidatedCartAction
{
    public function execute(User $user, ?string $couponCode = null ,$governorate_id): CartValidationResult
    {
        $cart = Cart::with([
            'items.product.images',
            'items.variant.attributeValues.attribute',
        ])->where('user_id', $user->id)->first();

        if (! $cart || $cart->items->isEmpty()) {
            throw new EmptyCartException();
        }

        $priceChanged = false;

        foreach ($cart->items as $item) {
            // ── Product existence & active status ──────────────────
            $product = $item->product;

            if (! $product) {

                throw new ProductUnavailableException('Unknown product');
            }

            if (! $product->status) {
                throw new ProductUnavailableException($product->getNameTranslated());
            }

            // ── Variant existence ───────────────────────────────────
          $variant = $item->variant
    ? $item->variant
    : (!$item->product->has_variants
        ? $product->firstVariant()
        : null);

            if (! $variant && $product->has_variants) {
                throw new ProductUnavailableException($product->getNameTranslated());
            }

            // ── Stock check ─────────────────────────────────────────
            if ($variant->manage_stock && $variant->stock < $item->quantity) {
                throw new OutOfStockException(
                    productName: $product->getNameTranslated(),
                    available:   $variant->stock,
                    requested:   $item->quantity,
                );
            }

            // ── Price drift detection ───────────────────────────────
            // getPriceAfterDiscount() on the variant is the source of truth
            $currentPrice = $variant->getPriceAfterDiscount();

            if ((float) $item->price !== (float) $currentPrice) {
                // Update cart item to the real price so totals are accurate
                $item->update(['price' => $currentPrice]);
                $item->price  = $currentPrice;
                $priceChanged = true;
            }
        }

        // ── Reload items after potential price updates ──────────────
        $cart->refresh();
        $items    = $cart->items;
        $subtotal = $items->sum(fn ($i) => $i->price * $i->quantity);

        // ── Coupon validation ───────────────────────────────────────
        $coupon   = null;
        $discount = 0.0;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->valid()->first();
            if ($coupon) {
                $discount = round($subtotal * ($coupon->discount_precentage / 100), 2);
            }
            // if coupon not found / expired we silently ignore it
            // so the order can still proceed — UI already showed validation
        }
$governorate = Governorate::with('shippingPrice')->find($governorate_id);     if (! $governorate) {
         throw new ProductUnavailableException('Invalid governorate selected');
     }
$shippingPrice = $governorate->shippingPrice?->price ?? 0;
$total         = max(0, $subtotal - $discount) + $shippingPrice;

        return new CartValidationResult(
            items:         $items,
            subtotal:      $subtotal,
            coupon:        $coupon,
            discount:      $discount,
            shippingPrice: $shippingPrice,
            total:         $total,
            priceChanged:  $priceChanged,
        );
    }
}
