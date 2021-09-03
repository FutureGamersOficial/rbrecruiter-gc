<?php


namespace App\Services;


use App\Application;
use App\Appointment;
use App\Exceptions\InvalidAppointmentStatusException;
use App\Notifications\ApplicationMoved;
use App\Notifications\AppointmentScheduled;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentService
{
    private $allowedPlatforms = [

        'ZOOM',
        'DISCORD',
        'SKYPE',
        'MEET',
        'TEAMSPEAK',

    ];

    public function createAppointment(Application $application, Carbon $appointmentDate, $appointmentDescription, $appointmentLocation)
    {
        $appointment = Appointment::create([
            'appointmentDescription' => $appointmentDescription,
            'appointmentDate' => $appointmentDate->toDateTimeString(),
            'applicationID' => $application->id,
            'appointmentLocation' => (in_array($appointmentLocation, $this->allowedPlatforms)) ? $appointmentLocation : 'DISCORD',
        ]);
        $application->setStatus('STAGE_INTERVIEW_SCHEDULED');

        Log::info('User '.Auth::user()->name.' has scheduled an appointment with '.$application->user->name.' for application ID'.$application->id, [
            'datetime' => $appointmentDate->toDateTimeString(),
            'scheduled' => now(),
        ]);

        $application->user->notify(new AppointmentScheduled($appointment));


        return true;
    }

    /**
     * Updates the appointment with the new $status.
     * It also sets the application's status to peer approval.
     *
     * Set $updateApplication to false to only update its status
     *
     * @throws InvalidAppointmentStatusException
     */
    public function updateAppointment(Application $application, $status, $updateApplication = true)
    {
        if ($status == 'SCHEDULED' || $status == 'concluded')
        {
            $application->appointment->appointmentStatus = strtoupper($status);
            $application->appointment->save();

            if ($updateApplication)
            {
                $application->setStatus('STAGE_PEERAPPROVAL');
                $application->user->notify(new ApplicationMoved());
            }
        }
        else
        {
            throw new InvalidAppointmentStatusException("Invalid appointment status!");
        }

    }

    /**
     * @return string[]
     */
    public function getAllowedPlatforms(): array
    {
        return $this->allowedPlatforms;
    }

}
