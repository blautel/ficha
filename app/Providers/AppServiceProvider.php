<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Fix para MySQL "Specified key was too long"
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fix para MySQL "Specified key was too long"
        Schema::defaultStringLength(191);
    }
}
