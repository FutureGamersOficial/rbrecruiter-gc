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

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MojangStatusProvider extends ServiceProvider
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
        // TODO: (IMPORTANT) Switch this to Middleware
        if (! Cache::has('mojang_status')) {
            Log::info('Mojang Status Provider: Mojang Status not found in the cache; Sending new request.');

            try {
                $mcstatus = Http::get(config('general.urls.mojang.statuscheck'));
                Cache::put('mojang_status', base64_encode($mcstatus->body()), now()->addDays(3));
            } catch (ConnectException $connectException) {
                Log::critical('Could not connect to Mojang servers: Cannot check/refresh status', [
                    'message' => $connectException->getMessage(),
                ]);
            }
        }

        View::share('mcstatus', json_decode(base64_decode(Cache::get('mojang_status')), true));
    }
}
