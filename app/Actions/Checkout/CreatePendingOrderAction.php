<?php

namespace App\Actions\Checkout;

use App\DTOs\CartValidationResult;
use App\DTOs\CheckoutData;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;

/**
 * Step 2 of checkout.
 *
 * Creates the order and all order_items from the validated cart snapshot.
 * Order status is set to PENDING — payment has NOT happened yet.
 *
 * MUST be called inside a DB::transaction().
 */
class CreatePendingOrderAction
{
    public function execute(
        User                $user,
        CartValidationResult $cart,
        CheckoutData        $data,
    ): Order {
        // ── Create order ────────────────────────────────────────────
        $order = Order::create([
            'user_id'         => $user->id,
            'user_name'       => $data->name,
            'user_phone'      => $data->phone,
            'user_email'      => $data->email,
            'price'           => $cart->subtotal,
            'shipping_price'  => $cart->shippingPrice,
            'total_price'     => $cart->total,
            'note'            => $data->note ?? '',
            'status'          => OrderStatus::PENDING->value,
            'country'         => $data->country,
            'governorate'     => $data->governorate,
            'city'            => $data->city,
            'street'          => $data->street,
            'coupon'          => $cart->coupon?->code,
            'coupon_discount' => $cart->discount,
            'shipping_price' =>$cart->shippingPrice,
        ]);

        // ── Create order items ──────────────────────────────────────
        foreach ($cart->items as $item) {
            $product = $item->product;
            $variant = $item->variant ? $item->variant :$product->firstVariant();


            // Serialize variant attributes as snapshot (e.g. Color: Red, Size: XL)
            if($product->has_variants){
                $attributeSnapshot = $variant->attributeValues
                ->mapWithKeys(fn ($av) => [$av->attribute->name => $av->value])
                ->toArray();}
                else{$attributeSnapshot = null;}

            $order->items()->create([
                'product_id'         => $product->id,
                'product_variant_id' => $variant->id,
                'product_name'       => $product->getNameTranslated(),
                'product_desc'       => $product->getSmallDescTranslated(),
                'product_quantity'   => $item->quantity,
                'product_price'      => $item->price,
                'attributes'         => json_encode($attributeSnapshot),
            ]);
        }

        return $order->load('items');
    }
}
