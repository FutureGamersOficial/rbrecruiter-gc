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

namespace App\Http\Controllers;

use App\Application;
use App\User;
use App\Vacancy;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Note: The dashboard doesn't need a service because it doesn't contain any significant business logic

    public function index()
    {
        $totalPeerReview = Application::where('applicationStatus', 'STAGE_PEERAPPROVAL')->get()->count();
        $totalNewApplications = Application::where('applicationStatus', 'STAGE_SUBMITTED')->get()->count();
        $totalDenied = Application::where('applicationStatus', 'DENIED')->get()->count();
        $vacancies = Vacancy::where('vacancyStatus', '<>', 'CLOSED')->get();

        $totalDeniedSingle = Application::where([
            ['applicationStatus', '=', 'DENIED'],
            ['applicantUserID', '=', Auth::user()->id]
        ])->get();

        $totalNewSingle = Application::where([
            ['applicationStatus', '=', 'STAGE_SUBMITTED'],
            ['applicantUserID', '=', Auth::user()->id]
        ])->get();

        return view('dashboard.dashboard')
            ->with([
                'vacancies' => $vacancies,
                'totalUserCount' => User::all()->count(),
                'totalDenied' => $totalDenied,
                'totalPeerReview' => $totalPeerReview,
                'totalNewApplications' => $totalNewApplications,
                'totalNewSingle' => $totalNewSingle->count(),
                'totalDeniedSingle' => $totalDeniedSingle->count()
            ]);
    }
}
