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

}
