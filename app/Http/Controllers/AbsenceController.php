<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Exceptions\AbsenceNotActionableException;
use App\Http\Requests\StoreAbsenceRequest;
use App\Http\Requests\UpdateAbsenceRequest;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{

    /**
     * Determines whether someone already has an active leave of absence request
     *
     * @param User $user The user to check
     * @return bool Their status
     */
    private function hasActiveRequest(Authenticatable $user): bool {

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

    /**
     * Display a listing of absences.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Absence::class);

        return view('dashboard.absences.index')
            ->with('absences', Absence::all());
    }


    /**
     * Display a listing of absences belonging to the current user.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUserAbsences()
    {
        $this->authorize('viewOwn', Absence::class);

        return view('dashboard.absences.own')
            ->with('absences', Auth::user()->absences);

    }



    /**
     * Show the form for creating a new absence request.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Absence::class);

        return view('dashboard.absences.create')
            ->with('activeRequest', $this->hasActiveRequest(Auth::user()));
    }

    /**
     * Store a newly created request in storage.
     *
     * @param  \App\Http\Requests\StoreAbsenceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAbsenceRequest $request)
    {
        $this->authorize('create', Absence::class);

        if ($this->hasActiveRequest(Auth::user())) {
            return redirect()
                ->back()
                ->with('error', __('You already have an active request. Cancel it or let it expire first.'));
        }


        $absence = Absence::create([
            'requesterID' => Auth::user()->id,
            'start' => $request->start_date,
            'predicted_end' => $request->predicted_end,
            'available_assist' => $request->available_assist == "on",
            'reason' => $request->reason,
            'status' => 'PENDING',
        ]);

        return redirect()
            ->to(route('absences.show', ['absence' => $absence->id]))
            ->with('success', 'Absence request submitted for approval. You will receive email confirmation shortly.');
    }

    /**
     * Display the specified absence request.
     *
     * @param  \App\Absence  $absence
     */
    public function show(Absence $absence)
    {
        $this->authorize('view', $absence);

        return view('dashboard.absences.view')
            ->with([
               'absence' => $absence,
                'totalDays' => Carbon::parse($absence->start)->diffInDays($absence->predicted_end)
            ]);
    }

    /**
     * Approve the specified absence.
     *
     * @param Absence $absence
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function approveAbsence(Absence $absence): RedirectResponse
    {
        $this->authorize('approve', $absence);

        try
        {
            $absence->setApproved();
        }
        catch (AbsenceNotActionableException $notActionableException)
        {
            return redirect()
                ->back()
                ->with('error', $notActionableException->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', __('Absence request successfully approved. It will automatically transition to "Ended" on its predicted end date.'));
    }


    /**
     * Decline the specified absence.
     *
     * @param Absence $absence
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function declineAbsence(Absence $absence): RedirectResponse
    {
        $this->authorize('decline', $absence);

        try
        {
            $absence->setDeclined();
        } catch (AbsenceNotActionableException $notActionableException)
        {
            return redirect()
                ->back()
                ->with('error', $notActionableException->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', __('Absence request successfully declined.'));
    }


    /**
     * Cancel the specified absence.
     *
     * @param Absence $absence
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function cancelAbsence(Absence $absence): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('cancel', $absence);

        try
        {
            $absence->setCancelled();
        }
        catch (AbsenceNotActionableException $notActionableException)
        {
            return redirect()
                ->back()
                ->with('error', $notActionableException->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', __('Absence request successfully cancelled.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Absence $absence)
    {
        $this->authorize('delete', $absence);

        if ($absence->delete()) {
            return redirect()
                ->to(route('absences.index'))
                ->with('success', __('Absence request deleted.'));
        }
    }
}
