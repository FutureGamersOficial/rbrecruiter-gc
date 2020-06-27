<?php

namespace App\Policies;

use App\Ban;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BanPolicy
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
     * @param  \App\Ban  $ban
     * @return mixed
     */
    public function view(User $user, Ban $ban)
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
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ban  $ban
     * @return mixed
     */
    public function update(User $user, Ban $ban)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ban  $ban
     * @return mixed
     */
    public function delete(User $user, Ban $ban)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ban  $ban
     * @return mixed
     */
    public function restore(User $user, Ban $ban)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ban  $ban
     * @return mixed
     */
    public function forceDelete(User $user, Ban $ban)
    {
        //
    }
}
