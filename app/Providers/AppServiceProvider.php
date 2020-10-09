<?php

namespace App\Providers;

use App\Application;
use App\Observers\ApplicationObserver;
use App\Observers\UserObserver;
use App\User;

use Illuminate\Pagination\Paginator;
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
        
        // Keep using Bootstrap; Laravel 8 has the paginator use Tailwind. Quite opinionated tbh
        Paginator::useBootstrap();

        User::observe(UserObserver::class);
        Application::observe(ApplicationObserver::class);

        $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');
    }
}
