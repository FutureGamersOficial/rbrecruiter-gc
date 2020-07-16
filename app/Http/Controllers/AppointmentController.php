<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Requests\SaveNotesRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Appointment;
use App\Notifications\ApplicationMoved;
use App\Notifications\AppointmentScheduled;
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

    public function saveAppointment(Request $request, Application $application)
    {
        $this->authorize('create', Appointment::class);
        $appointmentDate = Carbon::parse($request->appointmentDateTime);

        $appointment = Appointment::create([
            'appointmentDescription' => $request->appointmentDescription,
            'appointmentDate' => $appointmentDate->toDateTimeString(),
            'applicationID' => $application->id,
            'appointmentLocation' => (in_array($request->appointmentLocation, $this->allowedPlatforms)) ? $request->appointmentLocation : 'DISCORD',
        ]);
        $application->setStatus('STAGE_INTERVIEW_SCHEDULED');


        Log::info('User ' . Auth::user()->name . ' has scheduled an appointment with ' . $application->user->name . ' for application ID' . $application->id, [
            'datetime' => $appointmentDate->toDateTimeString(),
            'scheduled' => now()
        ]);

        $application->user->notify(new AppointmentScheduled($appointment));
        $request->session()->flash('success', 'Appointment successfully scheduled @ ' . $appointmentDate->toDateTimeString());


        return redirect()->back();
    }

    public function updateAppointment(Request $request, Application $application, $status)
    {
      $this->authorize('update', $application->appointment);

        $validStatuses = [
          'SCHEDULED',
          'CONCLUDED'
        ];

        // NOTE: This is a little confusing, refactor
        $application->appointment->appointmentStatus = (in_array($status, $validStatuses)) ? strtoupper($status) : 'SCHEDULED';
        $application->appointment->save();

        $application->setStatus('STAGE_PEERAPPROVAL');
        $application->user->notify(new ApplicationMoved());


        $request->session()->flash('success', 'Interview finished! Staff members can now vote on it.');
        return redirect()->back();
    }

    // also updates
    public function saveNotes(SaveNotesRequest $request, $application)
    {
        if (!is_null($application))
        {
            $application->appointment->meetingNotes = $request->noteText;
            $application->appointment->save();

            $request->session()->flash('success', 'Meeting notes have been saved.');
        }
        else
        {
            $request->session()->flash('error', 'There\'s no appointment to save notes to!');
        }

        return redirect()->back();
    }

}
