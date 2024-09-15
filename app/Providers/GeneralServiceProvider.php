<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class GeneralServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        App::bind('general', function () {
            return new \App\Models\General;
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
