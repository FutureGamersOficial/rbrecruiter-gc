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

use App\Exceptions\InvalidInviteException;
use App\Exceptions\PublicTeamInviteException;
use App\Exceptions\UserAlreadyInvitedException;
use App\Http\Requests\EditTeamRequest;
use App\Http\Requests\NewTeamRequest;
use App\Http\Requests\SendInviteRequest;
use App\Mail\InviteToTeam;
use App\Services\TeamService;
use App\Team;
use App\User;
use App\Vacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Exceptions\UserNotInTeamException;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

class TeamController extends Controller
{
    private $teamService;

    public function __construct(TeamService $teamService) {
        $this->teamService = $teamService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $this->authorize('index', Team::class);

        $teams = Team::with('users.roles')->get();

        return view('dashboard.teams.teams')
            ->with('teams', $teams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewTeamRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(NewTeamRequest $request)
    {
        $this->authorize('create', Team::class);
        $this->teamService->createTeam($request->teamName, Auth::user()->id);

        return redirect()
            ->back()
            ->with('success', __('Team successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Team $team)
    {
        $this->authorize('update', $team);
        return view('dashboard.teams.edit-team')
            ->with([
               'team' => $team,
               'users' => User::all(),
               'vacancies' =>  Vacancy::with('teams')->get()->all()
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditTeamRequest $request
     * @param Team $team
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(EditTeamRequest $request, Team $team): RedirectResponse
    {
        $this->authorize('update', $team);
        $team = $this->teamService->updateTeam($team, $request->teamDescription, $team->joinType);


        if ($team) {
            return redirect()
                ->to(route('teams.index'))
                ->with('success', __('Team updated.'));
        }

        return redirect()
            ->back()
            ->with('error', __('An error ocurred while trying to update this team.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // wip
    }

    public function invite(SendInviteRequest $request, Team $team): RedirectResponse
    {
        $this->authorize('invite', $team);

        try {

            $this->teamService->inviteUser($team, $request->user);

            return redirect()
                ->back()
                ->with('success', __('User invited successfully!'));

        } catch (UserAlreadyInvitedException | PublicTeamInviteException $ex) {
            return redirect()
                ->back()
                ->with('error', $ex->getMessage());
        }
    }

    public function processInviteAction(Request $request, $action, $token): RedirectResponse
    {
        try {

            $this->teamService->processInvite(Auth::user(), $action, $token);

            return redirect()
                ->to(route('teams.index'))
                ->with('success', __('Invite processed successfully!'));

        } catch (InvalidInviteException $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());

        }
    }

    public function switchTeam(Request $request, Team $team): RedirectResponse
    {
        $this->authorize('switchTeam', $team);

        try {
            Auth::user()->switchTeam($team);

            $request->session()->flash('success', __('Switched teams! Your team dashboard will now use this context.'));
        } catch (UserNotInTeamException $ex) {
            $request->session()->flash('error', __('You can\'t switch to a team you don\'t belong to.'));
        }

        return redirect()->back();
    }

    // Since it's a separate form, we shouldn't use the same update method
    public function assignVacancies(Request $request, Team $team): RedirectResponse
    {
        $this->authorize('update', $team);
        $message = $this->teamService->updateVacancies($team, $request->assocVacancies);

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
