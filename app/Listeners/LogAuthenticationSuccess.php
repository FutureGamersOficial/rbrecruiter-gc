<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogAuthenticationSuccess
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
        Log::info('SECURITY (postauth-pre2fa): Detected successful login attempt', [
            'accountID' => $event->user->id,
            'sourceIP' => request()->ip(),
            'matchesAccountLastIP' => request()->ip() == $event->user->originalIP,
            'sourceUserAgent' => request()->userAgent(),
        ]);
    }
}
