<?php

namespace App\Providers;

use App\Platforms\Bx8\Bx8Integrator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('bx8', function() {
            return new Bx8Integrator();
        }, true);
    }
}
