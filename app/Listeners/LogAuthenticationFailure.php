<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogAuthenticationFailure
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
    public function handle($event)
    {
        $targetAccountID = 0;
        $originalIP = "0.0.0.0";

        if (isset($event->user->id))
        {
            $targetAccountID = $event->user->id;
        }

        Log::alert('SECURITY (login): Detected failed authentication attempt!', [
            'targetAccountID' => $targetAccountID,
            'existingAccount' => ($targetAccountID == 0) ? false : true,
            'sourceIP' => request()->ip(),
            'matchesAccountLastIP' => request()->ip() == $originalIP,
            'sourceUserAgent' => request()->userAgent(),
        ]);
    }
}
