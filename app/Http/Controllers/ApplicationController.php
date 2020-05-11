<?php

namespace App\Http\Controllers;

use App\Application;
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
            return redirect()->to(route('userPendingApps'));
        }
        else
        {
            Log::warning('Application form for ' . Auth::user()->name . ' contained errors, resetting!');
            $request->session()->flash('error', 'There are one or more errors in your application. Please make sure none of your fields are empty, since they are all required.');

        }

        return redirect()->back();
    }
}
