<?php

namespace App\Http\Middleware;

use App\Facades\Options;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordExpirationMiddleware
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
        if(Auth::check())
        {
            $sinceUpdate = Carbon::parse(Auth::user()->password_last_updated)->diffInDays(now());
            $updateThreshold = Options::getOption('password_expiry');

            if ($updateThreshold !== 0 && $sinceUpdate > $updateThreshold)
            {
                session()->put('passwordExpired', true);
            }
            else
            {
                session()->put('passwordExpired', false);
            }

        }

        return $next($request);
    }
}
