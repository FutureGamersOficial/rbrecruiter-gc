<?php

namespace App\Services;

use App\Absence;
use App\Exceptions\AbsenceNotActionableException;
use App\Notifications\AbsenceRequestApproved;
use App\Notifications\AbsenceRequestCancelled;
use App\Notifications\AbsenceRequestDeclined;
use App\Notifications\AbsenceRequestEnded;
use App\Notifications\NewAbsenceRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;


class AbsenceService
{

    /**
     * Determines whether someone already has an active leave of absence request
     *
     * @param User $user The user to check
     * @return bool Their status
     */
    public function hasActiveRequest(Authenticatable $user): bool {

        $absences = Absence::where('requesterID', $user->id)->get();

        foreach ($absences as $absence) {

            // Or we could adjust the query (using a model scope) to only return valid absences;
            // If there are any, refuse to store more, but this approach also works
            // A model scope that only returns cancelled, declined and ended absences could also be implemented for future use
            if (in_array($absence->getRawOriginal('status'), ['PENDING', 'APPROVED']))
            {
                return true;
            }
        }

        return false;
    }

    public function createAbsence(Authenticatable $requester, Request $request)
    {

        $absence = Absence::create([
            'requesterID' => $user->id,
            'start' => $request->start_date,
            'predicted_end' => $request->predicted_end,
            'available_assist' => $request->available_assist == "on",
            'reason' => $request->reason,
            'status' => 'PENDING',
        ]);

        foreach(User::role('admin')->get() as $admin) {
            $admin->notify(new NewAbsenceRequest($absence));
        }

        Log::info('Processing new leave of absence request.', [
            'requesting_user' => $user->email,
            'absenceid' => $absence->id,
            'reason' => $request->reason
        ]);

        return $absence;
    }


    /**
     * Sets an absence as Approved.
     *
     * @param Absence $absence The absence to approve.
     * @return Absence The approved absence.
     * @throws AbsenceNotActionableException
     */
    public function approveAbsence(Absence $absence): Absence
    {
        Log::info('An absence request has just been approved.', [
            'absenceid' => $absence->id,
            'reviewing_admim' => Auth::user()->email,
            'new_status' => 'APPROVED'
        ]);

        return $absence
            ->setApproved()
            ->requester->notify(new AbsenceRequestApproved($absence));
    }


    /**
     * Sets an absence as Declined.
     *
     * @param Absence $absence The absence to decline.
     * @return Absence The declined absence.
     * @throws AbsenceNotActionableException
     */
    public function declineAbsence(Absence $absence): Absence
    {
        Log::warning('An absence request has just been declined.', [
            'absenceid' => $absence->id,
            'reviewing_admim' => Auth::user()->email,
            'new_status' => 'DECLINED'
        ]);

        return $absence
            ->setDeclined()
            ->requester->notify(new AbsenceRequestDeclined($absence));
    }


    /**
     * Sets an absence as Cancelled.
     *
     * @param Absence $absence The absence to cancel.
     * @return Absence The cancelled absence.
     * @throws AbsenceNotActionableException
     */
    public function cancelAbsence(Absence $absence)
    {
        Log::warning('An absence request has just been cancelled (only cancellable by requester).', [
            'absenceid' => $absence->id,
            'new_status' => 'CANCELLED'
        ]);

        return $absence
            ->setCancelled()
            ->requester->notify(new AbsenceRequestCancelled($absence));
    }

    /**
     * Sets an absence as Ended.
     *
     * @param Absence $absence
     * @return bool
     */
    public function endAbsence(Absence $absence): Absence
    {
        Log::info('An absence request has just expired.', [
            'absenceid' => $absence->id,
            'new_status' => 'ENDED'
        ]);

        return $absence
            ->setEnded()
            ->requester->notify(new AbsenceRequestEnded($absence));
    }

    /**
     * Removes an absence
     *
     * @param Absence $absence The absence to remove.
     * @return bool Whether the absence was removed.
     */
    public function removeAbsence(Absence $absence): bool
    {
        Log::alert('An absence request has just been removed.', [
            'absence_details' => $absence,
            'reviewing_admim' => Auth::user()->email,
        ]);

        return $absence->delete();
    }


    public function endExpired()
    {
        foreach (Absence::all() as $absence)
        {
            if (!Carbon::parse($absence->predicted_end)->isFuture()) {
                $this->endAbsence($absence);
            }
        }
    }



}

