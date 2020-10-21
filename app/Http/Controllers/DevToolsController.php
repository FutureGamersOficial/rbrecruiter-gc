<?php

namespace App\Http\Controllers;

use App\Application;
use App\Events\ApplicationApprovedEvent;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DevToolsController extends Controller
{

    // The use case for Laravel's gate and/or validation Requests is so tiny here that a full-blown policy would be overkill.
    protected function isolatedAuthorise()
    {
      if (!Auth::user()->can('admin.developertools.use'))
      {
        abort(403, 'You\'re not authorized to access this page.');
      }
    }

    public function index()
    {
        $this->isolatedAuthorise();
        return view('dashboard.administration.devtools')
            ->with('applications', Application::where('applicationStatus', 'STAGE_PEERAPPROVAL')->get());
    }

    public function forceVoteCount(Request $request)
    {
        $this->isolatedAuthorise();
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
