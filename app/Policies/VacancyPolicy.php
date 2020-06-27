<?php

namespace App\Policies;

use App\User;
use App\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
{
    use HandlesAuthorization;
    // TODO: Switch to permissions (there are no specific permissions yet)
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole('admin', 'hiringManager');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function view(User $user, Vacancy $vacancy)
    {
        // unused
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyRole('admin', 'hiringManager');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function update(User $user, Vacancy $vacancy)
    {
        return $user->hasRole('admin', 'hiringManager');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function delete(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function restore(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function forceDelete(User $user, Vacancy $vacancy)
    {
        //
    }
}
