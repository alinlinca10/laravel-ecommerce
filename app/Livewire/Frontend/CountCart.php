<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class CountCart extends Component
{
    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function updateCart()
    {
        $cartContent = Cart::content();

        return view('livewire.frontend.count-cart', ['cartContent' => $cartContent]);
    }

    public function render()
    {
        return view('livewire.frontend.count-cart');
    }
}
