<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        App::bind('product', function () {
            return new \App\Models\Store\Product;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
