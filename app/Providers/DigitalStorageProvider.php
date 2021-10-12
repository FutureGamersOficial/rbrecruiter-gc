<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class DigitalStorageProvider extends ServiceProvider
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
        App::bind('digitalStorageHelperFacadeRoot', function (){
            return new App\Helpers\DigitalStorageHelper();
        });
    }
}
