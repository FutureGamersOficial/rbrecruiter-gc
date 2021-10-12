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

namespace App\Observers;

use App\Profile;
use App\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function __construct()
    {
        Log::debug('User observer has been initialised and ready for use!');
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        Profile::create([

            'profileShortBio' => 'Write a one-liner about you here!',
            'profileAboutMe' => 'Tell us a bit about you.',
            'socialLinks' => '{}',
            'userID' => $user->id,

        ]);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    public function deleting(User $user)
    {
        if ($user->isForceDeleting()) {
            $user->profile->delete();
            Log::debug('Referential integrity cleanup: Deleted profile!');
            $applications = $user->applications;

            if (! $applications->isEmpty()) {
                Log::debug('RIC: Now trying to delete applications and responses...');
                foreach ($applications as $application) {
                    // code moved to Application observer, where it gets rid of attached elements individually
                    Log::debug('RIC: Deleting application '.$application->id);
                    $application->delete();
                }
            }
        } else {
            Log::debug('RIC: Not cleaning up soft deleted models!');
        }

        Log::debug('RIC: Cleanup done!');
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        Log::info('Model has been force deleted', [
            'modelID' => $user->id,
        ]);
    }
}
