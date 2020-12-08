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

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $teamUserPermissions = [

           'teams.files.view',
           'teams.files.upload',
           'teams.files.download',
           'teams.files.delete',
       ];

       // Some of these perms also check whether the user is a member or owner to determine access to resources.
       $teamPermissions = [

           'teams.view',
           'teams.create',
           'teams.update',
           'teams.invite'
       ];

        $admin = Role::where('name', 'admin')->first();
        $reviewer = Role::where('name', 'reviewer')->first();

       foreach($teamPermissions as $permission)
       {
           foreach ($teamUserPermissions as $userPermission)
           {
               Permission::create(['name' => $permission]);
               Permission::create(['name' => $userPermission]);

           }
       }

        $admin->givePermissionTo($teamPermissions);
        $reviewer->givePermissionTo($teamUserPermissions);






    }
}
