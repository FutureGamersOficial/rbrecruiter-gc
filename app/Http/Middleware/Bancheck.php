<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Bancheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userIP = $request->ip();
        $anonymousUser = User::where('ipAddress', $userIP)->get();

        
        if (Auth::check() && Auth::user()->isBanned())
        {
            View::share('isBanned', true);
        }
        elseif(!$anonymousUser->isEmpty() && User::find($anonymousUser->id)->isBanned())
        {
            View::share('isBanned', true);
        }
        else
        {
            View::share('isBanned', false);
        }

        return $next($request);
    }
}
