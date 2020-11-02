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

use App\Events\ApplicationDeniedEvent;
use App\Notifications\ApplicationDenied;
use Illuminate\Support\Facades\Log;

class DenyUser
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
     * @param ApplicationDeniedEvent $event
     * @return void
     */
    public function handle(ApplicationDeniedEvent $event)
    {
        $event->application->setStatus('DENIED');
        Log::info('User '.$event->application->user->name.' just had their application denied.');

        $event->application->user->notify(new ApplicationDenied($event->application));
    }
}
