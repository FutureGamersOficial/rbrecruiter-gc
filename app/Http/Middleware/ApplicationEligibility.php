<?php

namespace App\Http\Middleware;

use App\Application;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ApplicationEligibility
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $curtime = new Carbon(now());


        if (Auth::check())
        {
            $applications = Application::where('applicantUserID', Auth::user()->id)->get();
            $eligible = true;

            $daysRemaining = 0;

            if (!$applications->isEmpty())
            {
                foreach ($applications as $application)
                {
                    $appTime = Carbon::parse($application->created_at);
                    if ($appTime->isSameMonth($curtime))
                    {

                        Log::warning('Notice: Application ID ' . $application->id . ' was found to be in the same month as today\'s time, making the user ' . Auth::user()->name . ' ineligible for application');
                        $eligible = false;
                    }
                }

                $allowedTime = Carbon::parse($applications->last()->created_at)->addMonth();
                $daysRemaining = $allowedTime->diffInDays(now());

            }

            View::share('isEligibleForApplication', $eligible);
            View::share('eligibilityDaysRemaining', $daysRemaining);
        }


        return $next($request);
    }
}
