<?php

namespace App\Observers;

use App\Vacancy;


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

    /**
     * Handle the vacancy "deleted" event.
     *
     * @param  \App\Vacancy  $vacancy
     * @return void
     */
    public function deleted(Vacancy $vacancy)
    {
        // TODO: Handle deletion of children's data
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
