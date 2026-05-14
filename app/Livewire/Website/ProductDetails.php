<?php

namespace App\Livewire\Website;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ProductVariant;
use App\Models\CartItem;

class ProductDetails extends Component
{
    public $product;
    public $variantId;
    public $quantity;
    public $price;
    public $discount;
    public $cartQuantity = 1;
    public $inWishlist = false;
    public $cartAttributesArray = [];

    public function mount($product)
    {
        $this->product  = $product;
        $variant = $product->has_variants ? $product->variants->first() : null;

        $this->variantId = $variant?->id;
        $this->price     = $variant?->price;
        $this->quantity  = $variant?->stock;
        $this->discount  = $variant?->has_discount ? $variant->discount : 0;

        $this->checkWishlist();
    }

    public function changeVariant($variantId)
    {
        $variant = $this->product->variants->find($variantId);
        if (!$variant) return;

        $this->variantId = $variant->id;
        $this->price     = $variant->price;
        $this->quantity  = $variant->stock;
        $this->discount  = $variant->has_discount ? $variant->discount : 0;

        $this->checkWishlist(); // ✅ re-check wishlist on variant change
    }

    // --- Wishlist ---

    private function checkWishlist()
    {
        if (!auth('web')->check()) return;

        $this->inWishlist = \App\Models\Wishlist::where('user_id', auth('web')->id())
            ->where('product_id', $this->product->id)
            ->where('variant_id', $this->variantId)
            ->exists();
    }

    public function toggleWishlist()
    {
        if (!auth('web')->check()) {
            return redirect()->route('login');
        }

        if ($this->inWishlist) {
            \App\Models\Wishlist::where('user_id', auth('web')->id())
                ->where('product_id', $this->product->id)
                ->where('variant_id', $this->variantId)
                ->delete();

            $this->inWishlist = false;
        } else {
            \App\Models\Wishlist::firstOrCreate([
                'user_id'    => auth('web')->id(),
                'product_id' => $this->product->id,
                'variant_id' => $this->variantId,
            ]);

            $this->inWishlist = true;
            $this->dispatch('successMessage', __('website.product_added_to_wishlist'));
        }

        $this->dispatch('wishlistCountRefresh');
    }

    // --- Cart ---

    private function resolvedPrice(): float
    {
        $product = $this->product;

        if ($product->has_variants) {
            $variant = $product->variants->find($this->variantId);
            return $variant->has_discount ? $variant->price - $variant->discount : $variant->price;
        }

        return $product->has_discount ? $product->price - $product->discount : $product->price;
    }

    public function incrementCartQuantity() { $this->cartQuantity++; }

    public function decrementCartQuantity()
    {
        if ($this->cartQuantity > 1) $this->cartQuantity--;
    }

    public function addToCart()
    {
        $product = $this->product;
        $cart    = Cart::firstOrCreate(['user_id' => auth('web')->id()]);

        if ($product->has_variants) {
            $variant = $product->variants->find($this->variantId);
            $variant->load('VariantAttributes');

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_variant_id', $variant->id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $this->cartQuantity);
            } else {
                $attributes = $variant->VariantAttributes->mapWithKeys(
                    fn($va) => [$va->attributeValue->attribute->name => $va->attributeValue->value]
                )->toArray();

                $cart->items()->create([
                    'product_id'         => $product->id,
                    'product_variant_id' => $variant->id,
                    'price'              => $this->resolvedPrice(),
                    'quantity'           => $this->cartQuantity,
                    'attributes'         => json_encode($attributes, JSON_UNESCAPED_UNICODE),
                ]);
            }
        } else {
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->whereNull('product_variant_id')
                ->first();

            $cartItem
                ? $cartItem->increment('quantity', $this->cartQuantity)
                : $cart->items()->create([
                    'product_id'         => $product->id,
                    'product_variant_id' => null,
                    'price'              => $this->resolvedPrice(),
                    'quantity'           => $this->cartQuantity,
                ]);
        }

        $this->dispatch('successMessage', __('product_added_to_cart'));
        $this->dispatch('refreshCartIcon');
    }

    public function render()
    {
        return view('livewire.website.product-details', [
            'variants' => $this->product->variants,
        ]);
    }
}
