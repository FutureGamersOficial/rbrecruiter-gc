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
use App\Services\AccountSuspensionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class DevToolsController extends Controller
{
    public function __construct() {
        //
    }

    private function singleAuthorise() {
        if (! Auth::user()->can('admin.developertools.use')) {
            abort(403, __('You\'re not authorized to access this page.'));
        }
    }

    public function index() {
        $this->singleAuthorise();

        return view('dashboard.administration.devtools')
            ->with('applications', Application::where('applicationStatus', 'STAGE_PEERAPPROVAL')->get());
    }

    /**
     * Force an application to be approved.
     */
    public function forceApprovalEvent(Request $request) {
        $this->singleAuthorise();
        $application = Application::find($request->application);

        event(new ApplicationApprovedEvent($application));

        return redirect()
            ->back()
            ->with('success', __('Event dispatched; Candidate approval sequence initiated.'));
    }

    /**
     * Force an application to be rejected.
     */
    public function forceRejectionEvent(Request $request)
    {
        $this->singleAuthorise();
        $application = Application::findOrFail($request->application);

        event(new ApplicationDeniedEvent($application));

        return redirect()
            ->back()
            ->with('success', __('Event dispatched; Candidate rejection sequence initiated.'));
    }

    public function evaluateVotes() {

        $this->singleAuthorise();

        $code = Artisan::call("votes:evaluate");

        return redirect()
            ->back()
            ->with('success', 'Ran vote evaluation logic, with exit code ' . $code);

    }

    public function purgeSuspensions(AccountSuspensionService $service) {

        $this->singleAuthorise();

        if ($service->purgeExpired()) {
            return redirect()
                ->back()
                ->with('success', 'Force purged all expired suspensions.');
        }

        return redirect()
            ->back()
            ->with('error', 'There were no expired suspensions (or no suspensions at all) to purge.');

    }
}
