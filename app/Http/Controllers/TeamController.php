<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Http\Controllers;

use App\Http\Requests\EditTeamRequest;
use App\Http\Requests\NewTeamRequest;
use App\Http\Requests\SendInviteRequest;
use App\Mail\InviteToTeam;
use App\Team;
use App\User;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Exceptions\UserNotInTeamException;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::with('users.roles')->get();

        return view('dashboard.teams.teams')
            ->with('teams', $teams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewTeamRequest $request)
    {
        $team = Team::create([
            'name' => $request->teamName,
            'owner_id' => Auth::user()->id,
        ]);

        Auth::user()->teams()->attach($team->id);

        $request->session()->flash('success', 'Team successfully created.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        return view('dashboard.teams.edit-team')
              ->with('team', $team)
              ->with('users', User::all())
              ->with('vacancies', Vacancy::with('teams')->get()->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditTeamRequest $request, Team $team)
    {
        $team->description = $request->teamDescription;
        $team->openJoin = $request->joinType;

        $team->save();

        $request->session()->flash('success', 'Team edited successfully.');

        return redirect()->to(route('teams.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invite(SendInviteRequest $request, Team $team)
    {
        $user = User::findOrFail($request->user);

        if (! $team->openJoin) {
            if (! Teamwork::hasPendingInvite($user->email, $team)) {
                Teamwork::inviteToTeam($user, $team, function (TeamInvite $invite) use ($user) {
                    Mail::to($user)->send(new InviteToTeam($invite));
                });

                $request->session()->flash('success', 'Invite sent! They can now accept or deny it.');
            } else {
                $request->session()->flash('error', 'This user has already been invited.');
            }
        } else {
            $request->session()->flash('error', 'You can\'t invite users to public teams.');
        }

        return redirect()->back();
    }

    public function processInviteAction(Request $request, $action, $token)
    {
        switch ($action) {
            case 'accept':

                $invite = Teamwork::getInviteFromAcceptToken($token);

                if ($invite && $invite->user->is(Auth::user())) {
                    Teamwork::acceptInvite($invite);
                    $request->session()->flash('success', 'Invite accepted! You have now joined '.$invite->team->name.'.');
                } else {
                    $request->session()->flash('error', 'Invalid or expired invite URL.');
                }

               break;

            case 'deny':

                $invite = Teamwork::getInviteFromDenyToken($token);

                if ($invite && $invite->user->is(Auth::user())) {
                    Teamwork::denyInvite($invite);
                    $request->session()->flash('success', 'Invite denied! Ask for another invite if this isn\'t what you meant.');
                } else {
                    $request->session()->flash('error', 'Invalid or expired invite URL.');
                }

                break;

            default:
                $request->session()->flash('error', 'Sorry, but the invite URL you followed was malformed. Try asking for another invite, or submit a bug report.');

        }

        // This page will show the user's current teams
        return redirect()->to(route('teams.index'));
    }

    public function switchTeam(Request $request, Team $team)
    {
        try {
            Auth::user()->switchTeam($team);

            $request->session()->flash('success', 'Switched teams! Your team dashboard will now use this context.');
        } catch (UserNotInTeamException $ex) {
            $request->session()->flash('error', 'You can\'t switch to a team you don\'t belong to.');
        }

        return redirect()->back();
    }

    // Since it's a separate form, we shouldn't use the same update method
    public function assignVacancies(Request $request, Team $team)
    {
        // P.S. To future developers
        // This method gave me a lot of trouble lol. It's hard to write code when you're half asleep.
        // There may be an n+1 query in the view and I don't think there's a way to avoid that without writing a lot of extra code.

        $requestVacancies = $request->assocVacancies;
        $currentVacancies = $team->vacancies->pluck('id')->all();

        if (is_null($requestVacancies)) {
            foreach ($team->vacancies as $vacancy) {
                $team->vacancies()->detach($vacancy->id);
            }

            $request->session()->flash('success', 'Removed all vacancy associations.');

            return redirect()->back();
        }

        $vacancyDiff = array_diff($requestVacancies, $currentVacancies);
        $deselectedDiff = array_diff($currentVacancies, $requestVacancies);

        if (! empty($vacancyDiff) || ! empty($deselectedDiff)) {
            foreach ($vacancyDiff as $selectedVacancy) {
                $team->vacancies()->attach($selectedVacancy);
            }

            foreach ($deselectedDiff as $deselectedVacancy) {
                $team->vacancies()->detach($deselectedVacancy);
            }
        } else {
            $team->vacancies()->attach($requestVacancies);
        }

        $request->session()->flash('success', 'Assignments changed successfully.');

        return redirect()->back();
    }
}
