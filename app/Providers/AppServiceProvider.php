<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;


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
        if(Request::ip() === env('IP_DEBUG')){
            view()->share('es_debug', true);
        }

    }
}
