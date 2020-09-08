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
        Log::alert('SECURITY (login): Detected failed authentication attempt!', [
            'targetAccountID' => $event->user->id ?? '(nonexistent user)',
            'sourceIP' => request()->ip(),
            'matchesAccountLastIP' => request()->ip() == $event->user->originalIP,
            'sourceUserAgent' => request()->userAgent(),
        ]);
    }
}
