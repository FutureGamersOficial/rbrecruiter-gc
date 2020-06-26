<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\User;
use App\Notifications\NewUser;

class OnUserRegistration
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
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // TODO: Send push notification to online admins via browser (w/ pusher)
        Log::info('User ' . $event->user->name . ' has just registered for an account.');

        foreach(User::all() as $user)
        {
            if ($user->hasRole('admin'))
            {
                $user->notify(new NewUser($event->user));
            }
        }
    }
}
