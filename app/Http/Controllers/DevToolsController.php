<?php

namespace App\Http\Controllers;

use App\Application;
use App\Events\ApplicationApprovedEvent;
use Illuminate\Http\Request;

class DevToolsController extends Controller
{
    public function index()
    {
        return view('dashboard.administration.devtools')
            ->with('applications', Application::where('applicationStatus', 'STAGE_PEERAPPROVAL')->get());
    }

    public function forceVoteCount(Request $request)
    {
        $application = Application::find($request->application);

        if (!is_null($application))
        {
            event(new ApplicationApprovedEvent($application));

            $request->session()->flash('success', 'Event dispatched! Please check the debug logs for more info');
        }
        else
        {
            $request->session()->flash('error', 'Application doesn\'t exist!');
        }

        return redirect()->back();
    }
}
