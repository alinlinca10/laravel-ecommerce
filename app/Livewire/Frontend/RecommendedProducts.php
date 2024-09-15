<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Store\Product;

class RecommendedProducts extends Component
{
    public $product,$imgs;

    // public function mount($product, $imgs)
    // {
    //     $this->product = $product;
    //     $this->imgs = $imgs;
    // }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $qty = 1;
        $product_images = unserialize($product->pictures);
        $product_images = $product_images->first()->picture;
        Cart::add($product->id, $product->name, $qty, $product->price, ['picture' => $product_images]);

        $this->dispatch('cartUpdated');

        flash('Product added to your cart!')->success();
        
    }

    public function render()
    {
        return view('livewire.frontend.recommended-products');
    }
}
