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
use App\Events\ApplicationDeniedEvent;
use App\Http\Resources\ApplicationResource;
use App\Notifications\ApplicationMoved;
use App\Notifications\NewApplicant;
use App\Response;
use App\User;
use App\Vacancy;
use ContextAwareValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    private function canVote($votes): bool
    {
        $allvotes = collect([]);

        foreach ($votes as $vote) {
            if ($vote->userID == Auth::user()->id) {
                $allvotes->push($vote);
            }
        }

        return ($allvotes->count() == 1) ? false : true;
    }

    public function showUserApps()
    {
        return view('dashboard.user.applications')
            ->with('applications', Auth::user()->applications);
    }

    public function showUserApp(Request $request, Application $application)
    {
        if (!$request->wantsJson())
        {
            $this->authorize('view', $application);

            if (! is_null($application)) {
                return view('dashboard.user.viewapp')
                    ->with(
                        [
                            'application' => $application,
                            'comments' => $application->comments,
                            'structuredResponses' => json_decode($application->response->responseData, true),
                            'formStructure' => $application->response->form,
                            'vacancy' => $application->response->vacancy,
                            'canVote'  => $this->canVote($application->votes),
                        ]
                    );
            } else {
                $request->session()->flash('error', 'The application you requested could not be found.');
            }

            return redirect()->back();
        }

        return (new ApplicationResource($application))->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success'
            ]
        ]);
    }

    public function showAllApps(Request $request)
    {
        if (!$request->wantsJson())
        {
            $this->authorize('viewAny', Application::class);

            return view('dashboard.appmanagement.all')
                ->with('applications', Application::paginate(6));
        }


        // todo: eager load all relationships used
        return ApplicationResource::collection(Application::paginate(6))->additional([
            'code' => '200',
            'status' => 'success',
        ]);
    }


    public function renderApplicationForm(Request $request, $vacancySlug)
    {
        $vacancyWithForm = Vacancy::with('forms')->where('vacancySlug', $vacancySlug)->get();

        $firstVacancy = $vacancyWithForm->first();

        if (! $vacancyWithForm->isEmpty() && $firstVacancy->vacancyCount !== 0 && $firstVacancy->vacancyStatus == 'OPEN') {
            return view('dashboard.application-rendering.apply')
                ->with([
                    'vacancy' => $vacancyWithForm->first(),
                    'preprocessedForm' => json_decode($vacancyWithForm->first()->forms->formStructure, true),
                ]);
        } else {
            abort(404, 'The application you\'re looking for could not be found or it is currently unavailable.');
        }
    }

    public function saveApplicationAnswers(Request $request, $vacancySlug)
    {
        $vacancy = Vacancy::with('forms')->where('vacancySlug', $vacancySlug)->get();

        if ($vacancy->first()->vacancyCount == 0 || $vacancy->first()->vacancyStatus !== 'OPEN') {
            $request->session()->flash('error', 'This application is unavailable.');

            return redirect()->back();
        }

        Log::info('Processing new application!');

        $formStructure = json_decode($vacancy->first()->forms->formStructure, true);
        $responseValidation = ContextAwareValidator::getResponseValidator($request->all(), $formStructure);

        Log::info('Built response & validator structure!');

        if (! $responseValidation->get('validator')->fails()) {
            $response = Response::create([
                'responseFormID' => $vacancy->first()->forms->id,
                'associatedVacancyID' => $vacancy->first()->id, // Since a form can be used by multiple vacancies, we can only know which specific vacancy this response ties to by using a vacancy ID
                'responseData' => $responseValidation->get('responseStructure'),
            ]);

            Log::info('Registered form response for user '.Auth::user()->name.' for vacancy '.$vacancy->first()->vacancyName);

            $application = Application::create([
                'applicantUserID' => Auth::user()->id,
                'applicantFormResponseID' => $response->id,
                'applicationStatus' => 'STAGE_SUBMITTED',
            ]);

            Log::info('Submitted application for user '.Auth::user()->name.' with response ID'.$response->id);

            foreach (User::all() as $user) {
                if ($user->hasRole('admin')) {
                    $user->notify((new NewApplicant($application, $vacancy->first()))->delay(now()->addSeconds(10)));
                }
            }

            $request->session()->flash('success', 'Thank you for your application! It will be reviewed as soon as possible.');

            return redirect()->to(route('showUserApps'));
        } else {
            Log::warning('Application form for '.Auth::user()->name.' contained errors, resetting!');
            $request->session()->flash('error', 'There are one or more errors in your application. Please make sure none of your fields are empty, since they are all required.');
        }

        return redirect()->back();
    }

    public function updateApplicationStatus(Request $request, Application $application, $newStatus)
    {
        $this->authorize('update', Application::class);

        switch ($newStatus) {
            case 'deny':

                event(new ApplicationDeniedEvent($application));
                break;

            case 'interview':
                Log::info('User '.Auth::user()->name.' has moved application ID '.$application->id.'to interview stage');
                $request->session()->flash('success', 'Application moved to interview stage! (:');
                $application->setStatus('STAGE_INTERVIEW');

                $application->user->notify(new ApplicationMoved());
                break;

            default:
                $request->session()->flash('error', 'There are no suitable statuses to update to. Do not mess with the URL.');
        }

        return redirect()->back();
    }

    public function delete(Request $request, Application $application)
    {
        $this->authorize('delete', $application);
        $application->delete(); // observers will run, cleaning it up

        $request->session()->flash('success', 'Application deleted. Comments, appointments and responses have also been deleted.');

        return redirect()->back();
    }
}
