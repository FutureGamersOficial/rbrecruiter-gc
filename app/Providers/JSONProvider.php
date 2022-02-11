<?php

namespace App\Providers;

use App;
use App\Helpers\JSON;
use Illuminate\Support\ServiceProvider;

class JSONProvider extends ServiceProvider
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
        App::bind('json', function () {
           return new JSON();
        });
    }
}
