<?php

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
        if ($user->isForceDeleting())
        {
            $user->profile->delete();
            Log::debug('Referential integrity cleanup: Deleted profile!');
            $applications = $user->applications;
    
            if (!$applications->isEmpty())
            {
                Log::debug('RIC: Now trying to delete applications and responses...');
                foreach($applications as $application)
                {
                    // code moved to Application observer, where it gets rid of attached elements individually
                    Log::debug('RIC: Deleting application ' . $application->id);
                    $application->delete();
    
                }
            }

        }
        else
        {
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
            'modelID' => $user->id
        ]);
    }
}
