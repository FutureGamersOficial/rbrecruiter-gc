<?php


namespace App\Services;


use App\Application;
use App\Appointment;
use App\Exceptions\InvalidAppointmentStatusException;
use App\Notifications\ApplicationMoved;
use App\Notifications\AppointmentCancelled;
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

    /**
     * Schedules an appointment for the provided application.
     *
     * @param Application $application The target application.
     * @param Carbon $appointmentDate The appointment's date and time.
     * @param string $appointmentDescription The appointment description.
     * @param string $appointmentLocation The appointment location.
     * @return bool Whether the appointment was scheduled.
     */
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
     * Cancels an appointment for the provided application.
     *
     * @param Application $application The target application.
     * @param string $reason The reason for cancelling the appointment.
     * @throws \Exception Thrown when there's no appointment to cancel
     */
    public function deleteAppointment(Application $application, string $reason): bool
    {
        if (!empty($application->appointment))
        {
            $application->user->notify(new AppointmentCancelled($application, Carbon::parse($application->appointment->appointmentDate), $reason));
            $application->appointment->delete();

            $application->setStatus('STAGE_INTERVIEW');

            Log::info('User '.Auth::user()->name.' cancelled an appointment with '.$application->user->name.' for application ID'.$application->id);

            return true;
        }

        throw new \Exception("This application doesn't have an appointment!");

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
