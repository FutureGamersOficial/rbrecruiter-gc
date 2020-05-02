<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    public function showPendingUserApps()
    {
        return view('dashboard.user.applications');
    }

    public function showDeniedUserApps()
    {
        return view('dashboard.user.deniedapplications');
    }

    public function showApprovedApps()
    {
        return view('dashboard.user.approvedapplications');
    }

    public function showAllPendingApps()
    {
        return view('dashboard.appmanagement.outstandingapps');
    }

    public function showPeerReview()
    {
        return view('dashboard.appmanagement.peerreview');
    }

    public function showPendingInterview()
    {
        return view('dashboard.appmanagement.interview');
    }
}
