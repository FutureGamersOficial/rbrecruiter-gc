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
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ApplicationEligibility
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $eligible = false;
        $daysRemaining = __('N/A');

        if (Auth::check()) {

            $lastApplication = Application::where('applicantUserID', Auth::user()->id)->latest()->first();

            if (is_null($lastApplication)) {
                View::share('isEligibleForApplication', true);
                View::share('eligibilityDaysRemaining', 0);

                return $next($request);
            }

            $daysRemaining = $lastApplication->created_at->addMonth()->diffInDays(now());
            if ($lastApplication->created_at->diffInMonths(now()) > 1 && in_array($lastApplication->applicationStatus, ['DENIED', 'APPROVED'])) {

                $eligible = true;
            }

            Log::debug('Perfomed application eligibility check', [
                'eligible' => $eligible,
                'daysRemaining' => $daysRemaining,
                'ipAddress' => Auth::user()->originalIP,
                'checkUserID' => Auth::user()->id
            ]);

            View::share('isEligibleForApplication', $eligible);
            View::share('eligibilityDaysRemaining', $daysRemaining);
        }

        return $next($request);
    }
}
