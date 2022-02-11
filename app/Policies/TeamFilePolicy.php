<?php

namespace App\Policies;

use App\Team;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamFilePolicy
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
        return $user->hasPermissionTo('teams.files.view');
    }

    public function store(User $user, Team $team)
    {
        return $user->hasPermissionTo('teams.files.upload') || $user->hasTeam($team);
    }

    public function download(User $user)
    {
        return $user->hasPermissionTo('teams.files.download');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('teams.files.delete');
    }
}
