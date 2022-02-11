<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Http\Requests\StoreAbsenceRequest;
use App\Http\Requests\UpdateAbsenceRequest;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
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
            if (in_array($absence->status, ['PENDING', 'APPROVED']))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.absences.index')
            ->with('absences', Absence::all());
        // display for admin users
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.absences.create')
            ->with('activeRequest', $this->hasActiveRequest(Auth::user()));
    }

    /**
     * Store a newly created resource in storage.
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

        Absence::create([
            'requesterID' => Auth::user()->id,
            'start' => $request->start_date,
            'predicted_end' => $request->predicted_end,
            'available_assist' => $request->invalidAbsenceAgreement == 'on',
            'reason' => $request->reason,
            'status' => 'PENDING',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Absence request submitted for approval. You will receive email confirmation shortly.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Absence $absence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit(Absence $absence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAbsenceRequest  $request
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAbsenceRequest $request, Absence $absence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absence $absence)
    {
        //
    }
}
