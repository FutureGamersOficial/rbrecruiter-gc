<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceLogoutMiddleware
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
        if (Auth::user()->isBanned())
        {
            Auth::logout();

            $request->session()->flash('error', 'Error: Your session has been forcefully terminated. Please try again in a few days.');
            return redirect('/');
        }

        return $next($request);
    }
}
