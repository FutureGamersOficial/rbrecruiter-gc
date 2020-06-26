<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserBannedEvent;
use App\Notifications\UserBanned;

use Illuminate\Support\Facades\Log;

use App\User;

class OnUserBanned
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
     * @param  object  $event
     * @return void
     */
    public function handle(UserBannedEvent $event)
    {

        Log::warning("User " . $event->user->name . " has just been banned from the site!");

        foreach(User::all() as $user)
        {
          if ($user->isStaffMember())
          {
            $user->notify((new UserBanned($event->user, $event->ban))->delay(now()->addSeconds(10)));
          }
        }

    }
}
