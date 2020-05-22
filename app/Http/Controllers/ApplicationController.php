<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Response;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{

    public function showUserApps()
    {

        return view('dashboard.user.applications')
            ->with('applications', Auth::user()->applications);
    }

    public function showUserApp(Request $request, $applicationID)
    {
        $application = Application::find($applicationID);

        if (!is_null($application))
        {
            return view('dashboard.user.viewapp')
                ->with(
                    [
                        'application' => $application,
                        'structuredResponses' => json_decode($application->response->responseData, true),
                        'formStructure' => $application->response->form,
                        'vacancy' => $application->response->vacancy
                    ]
                );
        }
        else
        {
            $request->session()->flash('error', 'The application you requested could not be found.');
        }

        return redirect()->back();
    }


    public function showAllPendingApps()
    {
        return view('dashboard.appmanagement.outstandingapps')
            ->with('applications', Application::where('applicationStatus', 'STAGE_SUBMITTED')->get());
    }


    public function showPendingInterview()
    {
        $applications = Application::with('appointment', 'user')->get();
        $count = 0;

        $pendingInterviews = collect([]);
        $upcomingInterviews = collect([]);


        foreach ($applications as $application)
        {
            if (!is_null($application->appointment) && $application->appointment->appointmentStatus == 'CONCLUDED')
            {
                $count =+ 1;
            }

            switch ($application->applicationStatus)
            {
                case 'STAGE_INTERVIEW':
                    $upcomingInterviews->push($application);

                    break;

                case 'STAGE_INTERVIEW_SCHEDULED':
                    $pendingInterviews->push($application);

                    break;
            }

        }

        return view('dashboard.appmanagement.interview')
            ->with([
                'finishedCount' => $count,
                'applications' => $pendingInterviews,
                'upcomingApplications' => $upcomingInterviews
            ]);
    }

    public function showPeerReview()
    {
        return view('dashboard.appmanagement.peerreview')
            ->with('applications', Application::where('applicationStatus', 'STAGE_PEERAPPROVAL')->get());
    }

    public function renderApplicationForm(Request $request, $vacancySlug)
    {
        $vacancyWithForm = Vacancy::with('forms')->where('vacancySlug', $vacancySlug)->get();

        if (!$vacancyWithForm->isEmpty())
        {

            return view('dashboard.application-rendering.apply')
                ->with([

                    'vacancy' => $vacancyWithForm->first(),
                    'preprocessedForm' => json_decode($vacancyWithForm->first()->forms->formStructure, true)

                ]);
        }
        else
        {
            abort(404, 'We\'re ssssorry, but the application form you\'re looking for could not be found.');
        }

    }

    public function saveApplicationAnswers(Request $request, $vacancySlug)
    {
        $vacancy = Vacancy::with('forms')->where('vacancySlug', $vacancySlug)->get();

        Log::info('Processing new application!');

        $formStructure = json_decode($vacancy->first()->forms->formStructure, true);
        $responseStructure = [];

        $excludedNames = [
            '_token',
        ];

        $validator = [];

        foreach($request->all() as $fieldName => $value)
        {
            if(!in_array($fieldName, $excludedNames))
            {
                $validator[$fieldName] = 'required|string';

                $responseStructure['responses'][$fieldName]['type'] = $formStructure['fields'][$fieldName]['type'] ?? 'Unavailable';
                $responseStructure['responses'][$fieldName]['title'] = $formStructure['fields'][$fieldName]['title'];
                $responseStructure['responses'][$fieldName]['response'] = $value;
            }
        }

        Log::info('Built response & validator structure!');

        $validation = Validator::make($request->all(), $validator);

        if (!$validation->fails())
        {
            $response = Response::create([
                'responseFormID' => $vacancy->first()->forms->id,
                'associatedVacancyID' => $vacancy->first()->id, // Since a form can be used by multiple vacancies, we can only know which specific vacancy this response ties to by using a vacancy ID
                'responseData' => json_encode($responseStructure)
            ]);

            Log::info('Registered form response for user ' . Auth::user()->name . ' for vacancy ' . $vacancy->first()->vacancyName);

            Application::create([
                'applicantUserID' => Auth::user()->id,
                'applicantFormResponseID' => $response->id,
                'applicationStatus' => 'STAGE_SUBMITTED',
            ]);

            Log::info('Submitted application for user ' . Auth::user()->name . ' with response ID' . $response->id);

            $request->session()->flash('success', 'Thank you for your application! It will be reviewed as soon as possible.');
            return redirect()->to(route('showUserApps'));
        }
        else
        {
            Log::warning('Application form for ' . Auth::user()->name . ' contained errors, resetting!');
            $request->session()->flash('error', 'There are one or more errors in your application. Please make sure none of your fields are empty, since they are all required.');

        }

        return redirect()->back();
    }

    public function updateApplicationStatus(Request $request, $applicationID, $newStatus)
    {
        $application = Application::find($applicationID);

        if (!is_null($application))
        {
            switch ($newStatus)
            {
                case 'deny':

                    Log::info('User ' . Auth::user()->name . ' has denied application ID ' . $application->id);
                    $request->session()->flash('success', 'Application denied.');
                    $application->setStatus('DENIED');
                    break;

                case 'interview':
                    Log::info('User ' . Auth::user()->name . ' has moved application ID ' . $application->id . 'to interview stage');
                    $request->session()->flash('success', 'Application moved to interview stage! (:');
                    $application->setStatus('STAGE_INTERVIEW');
                    break;

                default:
                    $request->session()->flash('error', 'There are no suitable statuses to update to. Do not mess with the URL.');
            }
        }
        else
        {
            $request->session()->flash('The application you\'re trying to update does not exist.');
        }

        return redirect()->back();
    }
}
