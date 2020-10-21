<?php

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

        foreach ($votes as $vote)
        {
            Log::debug('Referential integrity cleanup: Deleting and detaching vote ' . $vote->id);
            $vote->application()->detach($application->id);
            $vote->delete();
        }

        if (!is_null($application->appointment))
        {
            Log::debug('RIC: Deleting appointment!');
            $application->appointment()->delete();
        }

        if (!$application->comments->isEmpty())
        {
            Log::debug('RIC: Deleting comments!');
            foreach($application->comments as $comment)
            {
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
