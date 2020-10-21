<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App;

class ContextAwareValidatorProvider extends ServiceProvider
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
      App::bind('contextAwareValidator', function(){

          return new App\Helpers\ContextAwareValidator();

      });
    }
}
