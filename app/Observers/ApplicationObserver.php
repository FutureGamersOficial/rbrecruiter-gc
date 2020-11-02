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

use App\Application;
use Illuminate\Support\Facades\Log;

class ApplicationObserver
{
    /**
     * Handle the application "created" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function created(Application $application)
    {
        //
    }

    /**
     * Handle the application "updated" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function updated(Application $application)
    {
        //
    }

    public function deleting(Application $application)
    {
        $application->response()->delete();
        $votes = $application->votes;

        foreach ($votes as $vote) {
            Log::debug('Referential integrity cleanup: Deleting and detaching vote '.$vote->id);
            $vote->application()->detach($application->id);
            $vote->delete();
        }

        if (! is_null($application->appointment)) {
            Log::debug('RIC: Deleting appointment!');
            $application->appointment()->delete();
        }

        if (! $application->comments->isEmpty()) {
            Log::debug('RIC: Deleting comments!');
            foreach ($application->comments as $comment) {
                $comment->delete();
            }
        }

        // application can now be deleted
    }

    /**
     * Handle the application "deleted" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function deleted(Application $application)
    {
        //
    }

    /**
     * Handle the application "restored" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function restored(Application $application)
    {
        //
    }

    /**
     * Handle the application "force deleted" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }
}
