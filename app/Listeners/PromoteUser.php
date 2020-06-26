<?php

namespace App\Listeners;

use App\Events\ApplicationApprovedEvent;
use App\StaffProfile;
use App\Notifications\ApplicationApproved;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PromoteUser
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
     * @param ApplicationApprovedEvent $event
     * @return void
     */
    public function handle(ApplicationApprovedEvent $event)
    {
        $event->application->setStatus('APPROVED');

        $staffProfile = StaffProfile::create([
            'userID' => $event->application->user->id,
            'approvalDate' => now()->toDateTimeString(),
            'memberNotes' => 'Approved by staff members. Welcome them to the team!'
        ]);

        $event->application->user->assignRole('reviewer');

        Log::info('User ' . $event->application->user->name . ' has just been promoted!', [
            'newRank' => $event->application->response->vacancy->permissionGroupName,
            'staffProfileID' => $staffProfile->id
        ]);

        $event->application->user->notify(new ApplicationApproved($event->application));
        // note: Also notify staff
        // TODO: Also assign new app role based on the permission group name

    }
}
