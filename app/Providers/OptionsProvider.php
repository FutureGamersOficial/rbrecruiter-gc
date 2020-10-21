<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class OptionsProvider extends ServiceProvider
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
        App::bind('smOptions', function (){
            return new App\Helpers\Options();
        });
    }
}
