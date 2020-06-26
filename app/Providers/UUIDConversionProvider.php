<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class UUIDConversionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        App::bind('uuidConversionFacade', function(){

            return new App\UUID\UUID();

        });
    }
}
