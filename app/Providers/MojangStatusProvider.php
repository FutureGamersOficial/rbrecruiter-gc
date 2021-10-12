<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Client\ConnectionException;

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
        $unknown_status = '[{"minecraft.net":"red"},{"session.minecraft.net":"red"},{"account.mojang.com":"red"},{"authserver.mojang.com":"red"},{"sessionserver.mojang.com":"red"},{"api.mojang.com":"red"},{"textures.minecraft.net":"red"},{"mojang.com":"red"}]';

        // TODO: (IMPORTANT) Switch this to Middleware
        if (!Cache::has('mojang_status'))
        {
            Log::info("Mojang Status Provider: Mojang Status not found in the cache; Sending new request.");

            try
            {
                $mcstatus = Http::get(config('general.urls.mojang.statuscheck'));
                Cache::put('mojang_status', base64_encode($mcstatus->body()), now()->addDays(3));
            }
            catch(ConnectionException $connectException)
            {
                // Shorter TTL because mojang status server might have recovered
                Cache::put('mojang_status', base64_encode($unknown_status), now()->addMinutes(60));
                
                Log::alert('Writing unknown Mojang status placeholder to cache');
                Log::critical('Could not connect to Mojang servers: Cannot check/refresh status', [
                    'message' => $connectException->getMessage()
                ]);
            }
        }

        View::share('mcstatus', json_decode(base64_decode(Cache::get('mojang_status')), true));
    }
}
