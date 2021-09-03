<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Providers;

use App\Application;
use App\Observers\ApplicationObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
            'release' => env('RELEASE'),
        ]);

        Schema::defaultStringLength(191);

        // Keep using Bootstrap; Laravel 8 has the paginator use Tailwind. Quite opinionated tbh
        Paginator::useBootstrap();

        User::observe(UserObserver::class);
        Application::observe(ApplicationObserver::class);


        $https = ($this->app->environment() != 'local');
        if(config('app.force_secure') && $this->app->environment() != 'production')
            $https = true;

        $this->app['request']->server->set('HTTPS', $https);

        View::share('demoActive', config('demo.is_enabled'));
    }
}
