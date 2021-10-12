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
use App\Events\ApplicationApprovedEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevToolsController extends Controller
{
    // The use case for Laravel's gate and/or validation Requests is so tiny here that a full-blown policy would be overkill.
    protected function isolatedAuthorise()
    {
        if (! Auth::user()->can('admin.developertools.use')) {
            abort(403, __('You\'re not authorized to access this page.'));
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

        if (! is_null($application)) {
            event(new ApplicationApprovedEvent($application));

            $request->session()->flash('success', __('Event dispatched! Please check the debug logs for more info'));
        } else {
            $request->session()->flash('error', __('Application doesn\'t exist!'));
        }

        return redirect()->back();
    }
}
