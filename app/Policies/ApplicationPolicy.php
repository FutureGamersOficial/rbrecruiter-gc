<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Policies;

use App\Application;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
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

    public function viewAny(User $user)
    {
        if ($user->can('applications.view.all')) {
            return Response::allow();
        }

        return Response::deny('Forbidden');
    }

    public function view(User $user, Application $application)
    {
        if ($user->is($application->user) && $user->can('applications.view.own') || $user->can('applications.view.all')) {
            return Response::allow();
        }

        return Response::deny('You are not authorised to view this application');
    }

    public function update(User $user)
    {
        return $user->hasAnyRole('admin', 'hiringManager');
    }

    public function delete(User $user, Application $application)
    {
        return $user->hasRole('admin');
    }
}
