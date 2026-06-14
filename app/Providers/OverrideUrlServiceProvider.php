<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class OverrideUrlServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Make URLs relative when ASSET_URL is empty
        if (empty(config('app.asset_url'))) {
            $this->app->make(UrlGenerator::class)->setRootControllerPath('/');
        }
    }
}
