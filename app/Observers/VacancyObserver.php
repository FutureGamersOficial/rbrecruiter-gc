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
use App\Vacancy;
use Illuminate\Support\Facades\Log;

class VacancyObserver
{
    /**
     * Handle the vacancy "created" event.
     *
     * @param  \App\Vacancy  $vacancy
     * @return void
     */
    public function created(Vacancy $vacancy)
    {
        //
    }

    /**
     * Handle the vacancy "updated" event.
     *
     * @param  \App\Vacancy  $vacancy
     * @return void
     */
    public function updated(Vacancy $vacancy)
    {
        //
    }

    public function deleting(Vacancy $vacancy)
    {
        foreach(Application::with('response.vacancy')->get() as $app) {
            if ($app->response->vacancy->id == $vacancy->id)
            {
                $app->delete();
            }
        }
    }

    /**
     * Handle the vacancy "deleted" event.
     *
     * @param  \App\Vacancy  $vacancy
     * @return void
     */
    public function deleted(Vacancy $vacancy)
    {

    }

    /**
     * Handle the vacancy "restored" event.
     *
     * @param  \App\Vacancy  $vacancy
     * @return void
     */
    public function restored(Vacancy $vacancy)
    {
        //
    }

    /**
     * Handle the vacancy "force deleted" event.
     *
     * @param  \App\Vacancy  $vacancy
     * @return void
     */
    public function forceDeleted(Vacancy $vacancy)
    {
        //
    }
}
