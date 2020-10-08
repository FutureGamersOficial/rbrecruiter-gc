<?php

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
            'owner_id' => Auth::user()->id
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
              ->with('vacancies', Vacancy::all());
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

        if (!$team->openJoin)
        {

            if (!Teamwork::hasPendingInvite($user->email, $team))
            {
                Teamwork::inviteToTeam($user, $team, function(TeamInvite $invite) use ($user) {
                    Mail::to($user)->send(new InviteToTeam($invite));
                });
    
                $request->session()->flash('success', 'Invite sent! They can now accept or deny it.');
            }
            else 
            {
                $request->session()->flash('error', 'This user has already been invited.');
            }

            
        }
        else
        {
            $request->session()->flash('error', 'You can\'t invite users to public teams.');
        }

        return redirect()->back();   
    }



    public function processInviteAction(Request $request, $action, $token)
    {
        
        switch($action)
        {
            case 'accept':

                $invite = Teamwork::getInviteFromAcceptToken($token);

                if ($invite && $invite->user->is(Auth::user()))
                {
                    Teamwork::acceptInvite($invite);
                    $request->session()->flash('success', 'Invite accepted! You have now joined ' . $invite->team->name . '.');
                }
                else
                {
                    $request->session()->flash('error', 'Invalid or expired invite URL.');
                }

               break;

            case 'deny':
                    
                $invite = Teamwork::getInviteFromDenyToken($token);

                if ($invite && $invite->user->is(Auth::user()))
                {
                    Teamwork::denyInvite($invite);
                    $request->session()->flash('success', 'Invite denied! Ask for another invite if this isn\'t what you meant.');
                }
                else
                {
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
        try
        {
            Auth::user()->switchTeam($team);

            $request->session()->flash('success', 'Switched teams! Your team dashboard will now use this context.');
        }
        catch(UserNotInTeamException $ex)
        {
            $request->session()->flash('error', 'You can\'t switch to a team you don\'t belong to.');
        }

        return redirect()->back();
    }
}
