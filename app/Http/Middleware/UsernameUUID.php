<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\UUID;
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
            $username = $input['uuid'];
            $input['uuid'] = UUID::toUUID($username);

            $request->replace($input);
        }
        return $next($request);
    }
}
