<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\Store\Product;

class FrontendCartController extends Controller
{
    public function addCart(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));
        Cart::add($product->id, $product->name, $request->input('qty'), $product->price, ['picture' => $request->input('picture')]);

        flash('Product added to your cart!')->success();
        return redirect()->back();
    }

    public function getRemoveCart($id)
    {
        Cart::remove($id);
        return redirect()->back();
    }

    public function postRemove($id)
    {
        Cart::remove($id);
        return redirect()->back();
    }

    public function destroyCart()
    {
        Cart::destroy();
        return redirect()->back();
    }
}
