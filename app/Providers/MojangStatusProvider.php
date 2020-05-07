<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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

        if (!Cache::has('mojang_status'))
        {
            Log::info("Mojang Status Provider: Mojang Status not found in the cache; Sending new request.");

            $mcstatus = Http::get(config('general.urls.mojang.statuscheck'));
            Cache::put('mojang_status', base64_encode($mcstatus->body()), now()->addMinutes(60));
        }

        View::share('mcstatus', json_decode(base64_decode(Cache::get('mojang_status')), true));
    }
}
