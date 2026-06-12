<?php

namespace App\Livewire\Website\Checkout;

use App\Models\Cart;
use App\Models\Coupon;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderSummary extends Component
{
    public $shippingPrice=0;


    #[On('shippingPriceUpdated')]
        #[On('couponApplied')]

    public function updateShippingPrice($price)
    {
        $this->shippingPrice = $price;
    }

    #[On('orderSummaryRefresh')]
    public function render()
{
    $cart = Cart::with('items')
        ->where('user_id', auth('web')->id())
        ->first();

    $couponInfo = null;

    if ($cart && $cart->coupon) {
        $couponInfo = Coupon::valid()
            ->where('code', $cart->coupon)
            ->first();
    }
    return view('livewire.website.checkout.order-summary', [
        'cart' => $cart,
        'couponInfo' => $couponInfo,
    ]);
}
}
