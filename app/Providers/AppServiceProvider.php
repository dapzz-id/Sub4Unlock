<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AdNetwork;
use App\Observers\AdNetworkObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        AdNetwork::observe(AdNetworkObserver::class);
    }
}