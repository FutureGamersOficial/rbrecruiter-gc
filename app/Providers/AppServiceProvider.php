<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Sentry;

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
        Sentry\init([
          'release' => env('RELEASE')
        ]);

        Schema::defaultStringLength(191);
        User::observe(UserObserver::class);

        $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');
    }
}
