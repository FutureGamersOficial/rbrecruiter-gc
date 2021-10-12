<?php


namespace App\Services;


use App\Application;
use App\Exceptions\InvalidAppointmentException;

class MeetingNoteService
{
    /**
     * Adds meeting notes to an application.
     *
     * @param Application $application
     * @param $noteText
     * @return bool
     * @throws InvalidAppointmentException Thrown when an application doesn't have an appointment to save notes to
     */
    public function addToApplication(Application $application, $noteText): bool {

        if (! is_null($application)) {
            $application->load('appointment');

            $application->appointment->meetingNotes = $noteText;
            $application->appointment->save();

            return true;

        } else {
            throw new InvalidAppointmentException('There\'s no appointment to save notes to!');
        }

    }

}
