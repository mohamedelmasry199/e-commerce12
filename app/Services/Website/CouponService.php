<?php

namespace App\Services\Website;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;

class CouponService
{
    public function validate(User $user, string $code): array
    {
        $coupon = Coupon::where('code', $code)->valid()->first();

        if (! $coupon) {
            return [
                'valid'   => false,
                'message' => __('checkout.invalid_coupon'),
            ];
        }

        $cart     = Cart::with('items')->where('user_id', $user->id)->first();
        $subtotal = $cart
            ? $cart->items->sum(fn ($i) => $i->price * $i->quantity)
            : 0;

        $discount = round($subtotal * ($coupon->discount_precentage / 100), 2);
        $shipping = (float) config('payment.shipping_price', 50);
        $total    = max(0, $subtotal - $discount) + $shipping;

        return [
            'valid'      => true,
            'code'       => $coupon->code,
            'percentage' => $coupon->discount_precentage,
            'discount'   => $discount,
            'subtotal'   => $subtotal,
            'shipping'   => $shipping,
            'total'      => $total,
            'message'    => __('checkout.coupon_applied', [
                'pct' => $coupon->discount_precentage,
            ]),
        ];
    }
}
