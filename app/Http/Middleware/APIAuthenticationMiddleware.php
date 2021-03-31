<?php

namespace App\Http\Middleware;

use App\ApiKey;
use App\Facades\JSON;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class APIAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $key = $request->bearerToken();

        if (!is_null($key))
        {
            // we have a valid discriminator
            $discriminator = Str::before($key, '.');
            $loneKey = Str::after($key, '.');

            $keyRecord = ApiKey::where('discriminator', $discriminator)->first();

            if ($keyRecord && Hash::check($loneKey, $keyRecord->secret) && $keyRecord->status == 'active')
            {
                Log::alert('API Authentication Success', [
                    'discriminator' => $discriminator
                ]);

                $keyRecord->last_used = Carbon::now();
                $keyRecord->save();

                return $next($request);
            }

            return JSON::setResponseType('error')
                ->setStatus('authfail')
                ->setMessage('Invalid / Revoked API key.')
                ->setCode(401)
                ->build();
        }

        return JSON::setResponseType('error')
            ->setStatus('malformed_key')
            ->setMessage('Missing or malformed API key.')
            ->setCode(400)
            ->build();

    }
}
