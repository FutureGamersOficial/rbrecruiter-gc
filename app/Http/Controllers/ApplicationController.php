<?php

namespace App\Http\Controllers;

use App\Vacancy;
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
}
