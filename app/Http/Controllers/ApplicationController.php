<?php

namespace App\Http\Controllers;

use App\Application;

use App\Response;
use App\Vacancy;
use App\User;

use App\Events\ApplicationDeniedEvent;
use App\Notifications\NewApplicant;
use App\Notifications\ApplicationMoved;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    private function canVote($votes)
    {
        $allvotes = collect([]);

        foreach ($votes as $vote)
        {
            if ($vote->userID == Auth::user()->id)
            {
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




    public function showUserApp(Request $request, $applicationID)
    {
        $application = Application::find($applicationID);

        $this->authorize('view', $application);

        if (!is_null($application))
        {
            return view('dashboard.user.viewapp')
                ->with(
                    [
                        'application' => $application,
                        'comments' => $application->comments,
                        'structuredResponses' => json_decode($application->response->responseData, true),
                        'formStructure' => $application->response->form,
                        'vacancy' => $application->response->vacancy,
                        'canVote'  => $this->canVote($application->votes)
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
        // FIXME: Get rid of references to first(), this is a wonky query
        $vacancyWithForm = Vacancy::with('forms')->where('vacancySlug', $vacancySlug)->get();

        $firstVacancy = $vacancyWithForm->first();

        if (!$vacancyWithForm->isEmpty() && $firstVacancy->vacancyCount !== 0 && $firstVacancy->vacancyStatus == 'OPEN')
        {

            return view('dashboard.application-rendering.apply')
                ->with([

                    'vacancy' => $vacancyWithForm->first(),
                    'preprocessedForm' => json_decode($vacancyWithForm->first()->forms->formStructure, true)

                ]);
        }
        else
        {
            abort(404, 'The application you\'re looking for could not be found or it is currently unavailable.');
        }

    }



    public function saveApplicationAnswers(Request $request, $vacancySlug)
    {
        $vacancy = Vacancy::with('forms')->where('vacancySlug', $vacancySlug)->get();

        if ($vacancy->first()->vacancyCount == 0 || $vacancy->first()->vacancyStatus !== 'OPEN')
        {

          $request->session()->flash('error', 'This application is unavailable.');
          return redirect()->back();

        }

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

            $application = Application::create([
                'applicantUserID' => Auth::user()->id,
                'applicantFormResponseID' => $response->id,
                'applicationStatus' => 'STAGE_SUBMITTED',
            ]);

            Log::info('Submitted application for user ' . Auth::user()->name . ' with response ID' . $response->id);

            foreach(User::all() as $user)
            {
              if ($user->hasRole('admin'))
              {
                $user->notify((new NewApplicant($application, $vacancy->first()))->delay(now()->addSeconds(10)));
              }
            }

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

                    event(new ApplicationDeniedEvent($application));
                    break;

                case 'interview':
                    Log::info('User ' . Auth::user()->name . ' has moved application ID ' . $application->id . 'to interview stage');
                    $request->session()->flash('success', 'Application moved to interview stage! (:');
                    $application->setStatus('STAGE_INTERVIEW');

                    $application->user->notify(new ApplicationMoved());
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
