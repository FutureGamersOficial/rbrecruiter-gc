<?php

namespace App\Observers;

use App\Profile;
use App\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
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
            'userID' => $user->id

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
        $user->profile()->delete();
        Log::debug('Referential integrity cleanup: Deleted profile!');
        $applications = $user->applications;

        if (!$applications->isEmpty())
        {
            Log::debug('RIC: Now trying to delete applications and responses...');
            foreach($applications as $application)
            {
                $application->response()->delete();
                $votes = $application->votes;

                foreach ($votes as $vote)
                {
                    Log::debug('RIC: Deleting and detaching vote ' . $vote->id);
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
                Log::debug('RIC: Deleting application ' . $application->id);
                $application->delete();

            }
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
        //
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
        //
    }
}
