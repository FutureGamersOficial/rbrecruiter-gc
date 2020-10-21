<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vacancy;
use App\User;
use App\Ban;
use App\Application;

class DashboardController extends Controller
{

    public function index()
    {
        $totalPeerReview = Application::where('applicationStatus', 'STAGE_PEERAPPROVAL')->get()->count();
        $totalNewApplications = Application::where('applicationStatus', 'STAGE_SUBMITTED')->get()->count();
        $totalDenied = Application::where('applicationStatus', 'DENIED')->get()->count();

        return view('dashboard.dashboard')
            ->with([
              'vacancies' => Vacancy::all(),
              'totalUserCount' => User::all()->count(),
              'totalDenied' => $totalDenied,
              'totalPeerReview' => $totalPeerReview,
              'totalNewApplications' => $totalNewApplications
            ]);

    }

}
