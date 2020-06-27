<?php

namespace App\Policies;

use App\User;
use App\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;

class VotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vote  $vote
     * @return mixed
     */
    public function view(User $user, Vote $vote)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('applications.vote');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vote  $vote
     * @return mixed
     */
    public function update(User $user, Vote $vote)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vote  $vote
     * @return mixed
     */
    public function delete(User $user, Vote $vote)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vote  $vote
     * @return mixed
     */
    public function restore(User $user, Vote $vote)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vote  $vote
     * @return mixed
     */
    public function forceDelete(User $user, Vote $vote)
    {
        //
    }
}
