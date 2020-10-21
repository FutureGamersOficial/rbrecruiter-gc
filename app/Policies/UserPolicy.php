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

    // This refers to the admin tools that let staff update more information than users themselves can
    public function adminEdit(User $authUser, User $user)
    {
      return $authUser->hasRole('admin') && $authUser->isNot($user);
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

    public function delete(User $authUser, User $subject)
    {
      return $authUser->hasRole('admin') && $authUser->isNot($subject);
    }
}
