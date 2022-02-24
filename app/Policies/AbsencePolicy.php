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
            return true;
        }

        return false;
    }


    public function viewOwn(User $user): bool
    {
        if ($user->hasPermissionTo('reviewer.viewAbsence')) {
            return true;
        }

        return false;
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
        if ($user->hasPermissionTo('reviewer.viewAbsence') && $user->is($absence->requester) || $user->hasPermissionTo('admin.manageAbsences'))
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
     * Determine whether the user can approve the absence request
     *
     * @param User $user
     * @param Absence $absence
     * @return bool
     */
    public function approve(User $user, Absence $absence): bool
    {
        if ($user->can('admin.manageAbsences') && $user->isNot($absence->requester))
        {
            return true;
        }

        return false;
    }


    public function decline(User $user, Absence $absence): bool
    {
        if ($user->can('admin.manageAbsences') && $user->isNot($absence->requester))
        {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can cancel the absence request
     *
     * @param User $user
     * @param Absence $absence
     * @return bool
     */
    public function cancel(User $user, Absence $absence): bool {

        if($user->is($absence->requester) && $user->can('reviewer.withdrawAbsence')) {
            return true;
        }

        return false;
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
        return $user->hasPermissionTo('admin.manageAbsences');
    }


}
