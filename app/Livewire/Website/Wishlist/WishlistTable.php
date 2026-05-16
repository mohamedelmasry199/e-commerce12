<?php

namespace App\Livewire\Website\Wishlist;

use App\Models\Wishlist;
use Livewire\Component;

class WishlistTable extends Component
{
    public $wishlists;
    public function removeFromWishlist($id){
        Wishlist::where('id',$id)->delete();
        $this->dispatch('wishlistCountRefresh');

    }
    public function clearWishlist(){
        auth('web')->user()->wishlists()->delete();
        $this->dispatch('wishlistCountRefresh');

    }
    public function render()
    {
        return view('livewire.website.wishlist.wishlist-table');
    }
}
