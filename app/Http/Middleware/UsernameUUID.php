<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;

class UsernameUUID
{
    /**
     * Converts a Minecraft username found in the request body to a UUID
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();
        if (isset($input['uuid']))
        {
            // TODO: Switch to custom Facade
            $username = $input['uuid'];

            $conversionRequest = Http::get(config('general.urls.mojang.api') . '/users/profiles/minecraft/' . $username)->body();
            $decodedConversionRequest = json_decode($conversionRequest, true);

            $input['uuid'] = $decodedConversionRequest['id'];

            $request->replace($input);
        }
        return $next($request);
    }
}
