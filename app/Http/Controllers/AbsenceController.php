<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Exceptions\AbsenceNotActionableException;
use App\Http\Requests\StoreAbsenceRequest;
use App\Http\Requests\UpdateAbsenceRequest;
use App\Services\AbsenceService;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{

    private AbsenceService $absenceService;

    public function __construct (AbsenceService $absenceService) {

        $this->absenceService = $absenceService;

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
            ->with('absences', Absence::paginate(6));
    }


    /**
     * Display a listing of absences belonging to the current user.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function showUserAbsences()
    {
        $this->authorize('viewOwn', Absence::class);

        // We can't paginate on the relationship found on the user model
        $absences = Absence::where('requesterID', Auth::user()->id)->paginate(6);

        return view('dashboard.absences.own')
            ->with('absences', $absences);

    }



    /**
     * Show the form for creating a new absence request.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Absence::class);

        return view('dashboard.absences.create')
            ->with('activeRequest', $this->absenceService->hasActiveRequest(Auth::user()));
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

        $absence = $this->absenceService->createAbsence(Auth::user(), $request);

        return redirect()
            ->to(route('absences.show', ['absence' => $absence->id]))
            ->with('success', __('Absence request submitted for approval. You will receive email confirmation shortly.'));
    }

    /**
     * Display the specified absence request.
     *
     * @param \App\Absence $absence
     * @throws AuthorizationException
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
     * @throws AuthorizationException
     */
    public function approveAbsence(Absence $absence): RedirectResponse
    {
        $this->authorize('approve', $absence);

        try
        {
            $this->absenceService->approveAbsence($absence);
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
     * @throws AuthorizationException
     */
    public function declineAbsence(Absence $absence): RedirectResponse
    {
        $this->authorize('decline', $absence);

        try
        {
            $this->absenceService->declineAbsence($absence);
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
     * @throws AuthorizationException
     */
    public function cancelAbsence(Absence $absence): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('cancel', $absence);

        try
        {
            $this->absenceService->cancelAbsence($absence);
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

        if ($this->absenceService->removeAbsence($absence)) {
            return redirect()
                ->to(route('absences.index'))
                ->with('success', __('Absence request deleted.'));
        }
    }
}
