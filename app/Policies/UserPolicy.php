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
