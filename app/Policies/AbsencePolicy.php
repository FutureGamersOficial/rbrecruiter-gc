<?php

namespace App\Policies;

use App\Absence;
use App\Response;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbsencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('admin.viewAllAbsences'))
        {
            return \Illuminate\Auth\Access\Response::allow();
        }

        return \Illuminate\Auth\Access\Response::deny('Forbidden');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Absence  $absence
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Absence $absence)
    {
        if ($user->hasPermissionTo('reviewer.viewAbsence') && $user->id == $absence->requesterID)
        {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('reviewer.requestAbsence');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Absence  $absence
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Absence $absence)
    {
        return $user->hasPermissionTo('admin.manageAbsences');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Absence  $absence
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Absence $absence)
    {
        return $user->hasPermissionTo('admin.manageAbsences') || $user->hasPermissionTo('reviewer.withdrawAbsence') && $user->id == $absence->requesterID;
    }

}
