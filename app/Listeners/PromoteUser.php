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

namespace App\Listeners;

use App\Events\ApplicationApprovedEvent;
use App\Notifications\ApplicationApproved;
use App\StaffProfile;
use Illuminate\Support\Facades\Log;

class PromoteUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ApplicationApprovedEvent $event
     * @return void
     */
    public function handle(ApplicationApprovedEvent $event)
    {
        $event->application->setStatus('APPROVED');

        $staffProfile = StaffProfile::create([
            'userID' => $event->application->user->id,
            'approvalDate' => now()->toDateTimeString(),
            'memberNotes' => 'Approved by staff members. Welcome them to the team!',
        ]);

        $event->application->user->assignRole('reviewer');

        Log::info('User '.$event->application->user->name.' has just been promoted!', [
            'newRank' => $event->application->response->vacancy->permissionGroupName,
            'staffProfileID' => $staffProfile->id,
        ]);

        $event->application->user->notify(new ApplicationApproved($event->application));
        // note: Also notify staff
        // TODO: Also assign new app role based on the permission group name
    }
}
