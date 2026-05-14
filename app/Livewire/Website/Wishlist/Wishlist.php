<?php

namespace App\Livewire\Website\Wishlist;

use Livewire\Component;

class Wishlist extends Component
{
    public $inWishlist = false;
    public $product;
    public $variantId;
    public function render()
    {
        return view('livewire.website.wishlist.wishlist');
    }
    public function mount($product ,$variantId = null)
    {
        $this->product = $product;
        $this->variantId = $variantId;
        $this->checkWishlist();
    }
    // public function toggleWishlist()
    // {
    //     if (auth('web')->check()) {
    //         $userId = auth('web')->user()->id;
    //         $wishlist = \App\Models\Wishlist::where('user_id', $userId)
    //             ->where('product_id', $this->product->id)
    //             ->first();
    //         if ($wishlist) {
    //             $wishlist->delete();
    //             $this->inWishlist = false;
    //         } else {
    //             \App\Models\Wishlist::create([
    //                 'user_id' => $userId,
    //                 'product_id' => $this->product->id,
    //             ]);
    //         }
    //         $this->checkWishlist();
    //     } else {
    //         session()->flash('error', 'Please login to manage your wishlist.');
    //     }
    // }
    private function checkWishlist()
    {
        if (auth('web')->check()) {
            $userId = auth('web')->user()->id;
            $this->inWishlist = \App\Models\Wishlist::where('user_id', $userId)
                ->where('product_id', $this->product->id)
                ->where('variant_id', $this->variantId)
                ->exists();
        }
    }
    public function removeFromWishlist()
    {
        if (auth('web')->check()) {
            $userId = auth('web')->user()->id;
            \App\Models\Wishlist::where('user_id', $userId)
                ->where('product_id', $this->product->id)
                ->where('variant_id', $this->variantId)
                ->delete();
            $this->inWishlist = false;
        }
    }
    public function addToWishlist()
    {
        if(!auth('web')->check()){
            return redirect()->route('login');
        }
        if (auth('web')->check()) {
            $userId = auth('web')->user()->id;
            \App\Models\Wishlist::firstOrCreate([
                'user_id' => $userId,
                'product_id' => $this->product->id,
                'variant_id' => $this->variantId,
            ]);
            $this->inWishlist = true;
        $this->dispatch('addToWishlist',__('website.product_added_to_wishlist'));
        $this->dispatch('wishlistCountRefresh');
        }
    }
}
