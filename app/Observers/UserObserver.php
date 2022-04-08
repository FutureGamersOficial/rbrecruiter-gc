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

use App\Exceptions\ProfileAlreadyExistsException;
use App\Exceptions\ProfileCreationFailedException;
use App\Profile;
use App\Services\ProfileService;
use App\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(ProfileService $profileService, User $user)
    {
        try
        {
            $profileService->createProfile($user);
        }
        catch (ProfileAlreadyExistsException $exception)
        {
            Log::error('Attempting to create profile that already exists!', [
                'trace' => $exception->getTrace()
            ]);
        }
        catch (ProfileCreationFailedException $e)
        {
            Log::error('Failed creating a new profile!', [
                'trace' => $e->getTrace()
            ]);
        }
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
