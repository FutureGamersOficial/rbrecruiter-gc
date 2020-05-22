<?php

namespace App\Http\Controllers;

use App\Application;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    private $allowedPlatforms = [

        'ZOOM',
        'DISCORD',
        'SKYPE',
        'MEET',
        'TEAMSPEAK'

    ];

    public function saveAppointment(Request $request, $applicationID)
    {
        // Unrelated TODO: change if's in application page to a switch statement, & have the row encompass it

        $app = Application::find($applicationID);

        if (!is_null($app))
        {
            // make sure this is a valid date by parsing it first
            $appointmentDate = Carbon::parse($request->appointmentDateTime);


            $appointment = Appointment::create([
                'appointmentDescription' => $request->appointmentDescription,
                'appointmentDate' => $appointmentDate->toDateTimeString(),
                'applicationID' => $applicationID,
                'appointmentLocation' => (in_array($request->appointmentLocation, $this->allowedPlatforms)) ? $request->appointmentLocation : 'DISCORD',
            ]);
            $app->setStatus('STAGE_INTERVIEW_SCHEDULED');


            Log::info('User ' . Auth::user()->name . ' has scheduled an appointment with ' . $app->user->name . ' for application ID' . $app->id, [
                'datetime' => $appointmentDate->toDateTimeString(),
                'scheduled' => now()
            ]);

            $request->session()->flash('success', 'Appointment successfully scheduled @ ' . $appointmentDate->toDateTimeString());

        }
        else
        {
            $request->session()->flash('error', 'Cant\'t schedule an appointment for an application that doesn\'t exist.');
        }

        return redirect()->back();
    }

    public function updateAppointment(Request $request, $applicationID, $status)
    {
        $application = Application::find($applicationID);
        $validStatuses = [
          'SCHEDULED',
          'CONCLUDED'
        ];


        if (!is_null($application))
        {
            $application->appointment->appointmentStatus = (in_array($status, $validStatuses)) ? strtoupper($status) : 'SCHEDULED';
            $application->appointment->save();

            $application->setStatus('STAGE_PEERAPPROVAL');

            $request->session()->flash('success', 'Interview finished! Staff members can now vote on it.');
        }
        else
        {
            $request->session()->flash('error', 'The application you\'re trying to update doesn\'t exist or have an appointment.');
        }

        return redirect()->back();
    }


}
