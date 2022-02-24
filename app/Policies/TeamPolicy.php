<?php

namespace App\Policies;

use App\Team;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(User $user)
    {
        return $user->hasPermissionTo('teams.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('teams.create');
    }

    public function update(User $user, Team $team)
    {
        // Team owners can update their team regardless of perm.
        // This perm would let admins change all teams
        return $user->isOwnerOfTeam($team) || $user->hasPermissionTo('teams.update');
    }


    public function invite(User $user, Team $team)
    {
        if (!$team->openJoin && $user->isOwnerOfTeam($team) || !$team->openJoin && $user->hasPermissionTo('teams.invite'))
        {
            return true;
        }

        return false;
    }

    public function switchTeam(User $user, Team $team): bool
    {
        // is the user in the team they're trying to switch to?
        return $user->hasTeam($team);
    }
}
