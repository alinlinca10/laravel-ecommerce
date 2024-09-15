<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Store\Product;
use App\Models\Page;

use Auth;

class FrontendPageController extends Controller
{
    public function home()
    {
        $items = Product::where('highlight', 1)->orderBy('created_at', 'DESC')->get();

        return view('frontend.home')
            ->with('items', $items);
    }
}
