<?php

namespace App\Policies;

use App\ApiKey;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiKeyPolicy
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
        if ($user->hasRole('admin'))
            return true;

        return false;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->hasRole('admin'))
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\ApiKey  $apiKey
     * @return mixed
     */
    public function update(User $user, ApiKey $apiKey)
    {
        if ($user->hasRole('admin'))
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ApiKey  $apiKey
     * @return mixed
     */
    public function delete(User $user, ApiKey $apiKey)
    {
        if ($user->hasRole('admin'))
            return true;

        return false;
    }

}
