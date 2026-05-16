<?php

namespace App\Livewire\Website\Cart;

use Livewire\Component;
use App\Models\CartItem;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    public $cartItems;
    public $cartItemsCount = 0;

    public function mount()
    {
        $this->loadCartData();
    }
        #[On('refreshCartIcon')]

    public function loadCartData()
    {
        $this->cartItems = collect();
        $this->cartItemsCount = 0;

        if (auth('web')->check()) {

            $user = auth('web')->user();

            $cart = $user->cart;

            if ($cart) {

                $this->cartItems = $cart->items()
                    ->with('product.images')
                    ->get();

                $this->cartItemsCount = $this->cartItems->count();
            }
        }
    }

    // public function removeItemFromCart($itemId)
    // {
    //     CartItem::find($itemId)?->delete();

    //     $this->loadCartData();

    //     $this->dispatch('cartUpdated');
    // }
     public function removeItemFromCart($id)
    {
        $authBoolean = auth('web')->check();
        if ($authBoolean) {
            $cartItem = auth('web')->user()->cart->items()->where('id', $id)->first();
            $cartItem->delete();
            $this->dispatch('updateCart');

            // delete coupon if the last item is deleted
            if (auth('web')->user()->cart->items->count() == 0) {
                auth('web')->user()->cart->update(['coupon' => null]);
            }
        }

        // new code : make event to refresh checkout component in case opened
        $this->dispatch('orderSummaryRefresh');
    }


    public function render()
    {
        return view('livewire.website.cart.cart-icon');
    }
}
