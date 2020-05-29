<?php

namespace App\Listeners;

use App\Events\ApplicationDeniedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DenyUser
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
     * @param ApplicationDeniedEvent $event
     * @return void
     */
    public function handle(ApplicationDeniedEvent $event)
    {
        $event->application->setStatus('DENIED');
        Log::info('User ' . $event->application->user->name . ' just had their application denied.');

        // Also dispatch other notifications
    }
}
