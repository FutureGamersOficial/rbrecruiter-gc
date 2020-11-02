<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Http\Middleware;

use App\Application;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        if (Auth::check()) {
            $applications = Application::where('applicantUserID', Auth::user()->id)->get();
            $eligible = true;

            $daysRemaining = 0;

            if (! $applications->isEmpty()) {
                foreach ($applications as $application) {
                    $appTime = Carbon::parse($application->created_at);
                    if ($appTime->isSameMonth($curtime)) {
                        Log::warning('Notice: Application ID '.$application->id.' was found to be in the same month as today\'s time, making the user '.Auth::user()->name.' ineligible for application');
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
