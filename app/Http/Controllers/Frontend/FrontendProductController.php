<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Store\Product;
use App\Models\Store\Category;
use App\Models\Store\ProductAttribute;
use Auth;
use stdClass;
use Input;
use Str;

class FrontendProductController extends Controller
{

    public function all(Request $request)
    {
        $products = Product::active()->get();
        // dd($product);

        return view('frontend.store.products')
            ->with('products', $products);
    }

    public function viewProduct($id)
    {
        // $product = Product::with(['product_attributes.attribute', 'product_attributes.attributeValue'])->where('id', $id)->first();
        $product = Product::where('id', $id)->first();

        // Grupăm atributele după tip
        $groupedAttributes = $product->attributeValues->groupBy(function ($attributeValue) {
            return $attributeValue->attribute->name;
        });

        return view('frontend.store.product')
            ->with('groupedAttributes', $groupedAttributes)
            ->with('product', $product);
    }
}
