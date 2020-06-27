<?php

namespace App\Policies;

use App\Appointment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
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
     * @param  \App\Appointment  $appointment
     * @return mixed
     */
    public function view(User $user, Appointment $appointment)
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
        return $user->can('appointments.schedule');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $appointment
     * @return mixed
     */
    public function update(User $user, Appointment $appointment)
    {
        return $user->can('appointments.schedule.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $appointment
     * @return mixed
     */
    public function delete(User $user, Appointment $appointment)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $appointment
     * @return mixed
     */
    public function restore(User $user, Appointment $appointment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $appointment
     * @return mixed
     */
    public function forceDelete(User $user, Appointment $appointment)
    {
        //
    }
}
