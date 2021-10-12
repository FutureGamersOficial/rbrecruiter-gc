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
use App\Appointment;
use App\Exceptions\InvalidAppointmentException;
use App\Exceptions\InvalidAppointmentStatusException;
use App\Http\Requests\SaveNotesRequest;
use App\Services\AppointmentService;
use App\Services\MeetingNoteService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    private $appointmentService;
    private $meetingNoteService;


    public function __construct(AppointmentService $appointmentService, MeetingNoteService $meetingNoteService) {

        $this->appointmentService = $appointmentService;
        $this->meetingNoteService = $meetingNoteService;
    }

    public function saveAppointment(Request $request, Application $application): RedirectResponse
    {
        $this->authorize('create', Appointment::class);

        $appointmentDate = Carbon::parse($request->appointmentDateTime);
        $this->appointmentService->createAppointment($application, $appointmentDate, $request->appointmentDescription, $request->appointmentLocation);

        return redirect()
            ->back()
            ->with('success',__('Appointment successfully scheduled @ :appointmentTime', ['appointmentTime', $appointmentDate->toDateTimeString()]));
    }

    /**
     * @throws AuthorizationException
     */
    public function updateAppointment(Application $application, $status): RedirectResponse
    {
        $this->authorize('update', $application->appointment);

        try {
            $this->appointmentService->updateAppointment($application, $status);

            return redirect()
                ->back()
                ->with('success', __("Interview finished! Staff members can now vote on it."));

        }
        catch (InvalidAppointmentStatusException $ex) {
            return redirect()
                ->back()
                ->with('error', $ex->getMessage());
        }


    }

    public function saveNotes(SaveNotesRequest $request, Application $application)
    {
        try {

            $this->meetingNoteService->addToApplication($application, $request->noteText);

            return redirect()
                ->back()
                ->with('success', 'Saved notes.');

        } catch (InvalidAppointmentException $ex) {
            return redirect()
                ->back()
                ->with('error', $ex->getMessage());
        }
    }
}
