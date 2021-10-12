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
use App\Exceptions\ApplicationNotFoundException;
use App\Exceptions\IncompleteApplicationException;
use App\Exceptions\UnavailableApplicationException;
use App\Exceptions\VacancyNotFoundException;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{

    private $applicationService;

    public function __construct(ApplicationService $applicationService) {

        $this->applicationService = $applicationService;
    }


    public function showUserApps()
    {
        return view('dashboard.user.applications')
            ->with('applications', Auth::user()->applications);
    }

    public function showUserApp(Request $request, Application $application)
    {
        $this->authorize('view', $application);

        if (!is_null($application)) {
            return view('dashboard.user.viewapp')
                ->with(
                    [
                        'application' => $application,
                        'comments' => $application->comments,
                        'structuredResponses' => json_decode($application->response->responseData, true),
                        'formStructure' => $application->response->form,
                        'vacancy' => $application->response->vacancy,
                        'canVote' => $this->applicationService->canVote($application->votes),
                    ]
                );
        } else {
            $request->session()->flash('error', __('The application you requested could not be found.'));
        }

        return redirect()->back();

    }

    public function showAllApps(Request $request)
    {
        $this->authorize('viewAny', Application::class);

        return view('dashboard.appmanagement.all')
            ->with('applications', Application::all());

    }


    public function renderApplicationForm($vacancySlug)
    {
        try {
            return $this->applicationService->renderForm($vacancySlug);
        }
        catch (ApplicationNotFoundException $ex) {
            return redirect()
                ->back()
                ->with('error', $ex->getMessage());
        }
    }

    public function saveApplicationAnswers(Request $request, $vacancySlug)
    {
        try {

            $this->applicationService->fillForm(Auth::user(), $request->all(), $vacancySlug);

        } catch (VacancyNotFoundException | IncompleteApplicationException | UnavailableApplicationException $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->to(route('showUserApps'))
            ->with('success', __('Thank you! Your application has been processed and our team will get to it shortly.'));
    }

    public function updateApplicationStatus(Request $request, Application $application, $newStatus)
    {
        $messageIsError = false;
        $this->authorize('update', Application::class);

        try {
            $status = $this->applicationService->updateStatus($application, $newStatus);
        } catch (\LogicException $ex)
        {
            return redirect()
                ->back()
                ->with('error', $ex->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', $status);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function delete(Request $request, Application $application)
    {
        $this->authorize('delete', $application);
        $this->applicationService->delete($application);

        return redirect()
            ->back()
            ->with('success', __('Application deleted. Comments, appointments and responses have also been deleted.'));

    }
}
