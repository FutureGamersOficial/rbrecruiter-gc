<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function edit(User $authUser, User $user)
    {
        return $authUser->is($user) || $authUser->hasRole('admin');
    }

    public function viewStaff(User $user)
    {
        return $user->can('admin.stafflist');
    }

    public function viewPlayers(User $user)
    {
        return $user->can('admin.userlist');
    }

    public function terminate(User $authUser)
    {
       return $authUser->hasRole('admin');
    }
}
