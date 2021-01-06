<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordExpirationRedirectMiddleware
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
        if (Auth::check() && session('passwordExpired'))
        {
            // WARNING!! Routes under the profile group must not have this middleware, because it'll result in an infinite redirect loop.
            return redirect(route('showAccountSettings'));
        }

        return $next($request);
    }
}
