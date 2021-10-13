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

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $user = Role::create(
            [
                'name' => 'user',
            ]
        );

        $reviewer = Role::create(
            [
                'name' => 'reviewer',
            ]
        );

        $hiringManager = Role::create(
            [
                'name' => 'hiringManager',
            ]
        );

        $admin = Role::create([
            'name' => 'admin',
        ]);

        // Spatie wildcard permissions (same concept of MC permissions)

        $permissions = [
            'applications.submit',
            'applications.stages.deny',
            'applications.stages.approve',
            'applications.view.all',
            'applications.view.own',
            'applications.vote',
            'appointments.schedule',
            'appointments.schedule.edit',
            'appointments.schedule.cancel',
            'applications.*',
            'appointments.*',

            'profiles.view.others',
            'profiles.edit.others',

            'admin.userlist',
            'admin.stafflist',
            'admin.hiring.forms',
            'admin.hiring.formbuilder',
            'admin.hiring.vacancy',
            'admin.hiring.vacancy.edit,delete',
            'admin.notificationsettings',
            'admin.notificationsettings.edit',
            'admin.hiring.*',
            'admin.notificationsettings.*',
            'admin.maintenance.logs.view',
            'admin.developertools.use',
        ];

        foreach ($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }

        $user->givePermissionTo([
            'applications.submit',
            'applications.view.own',
            'profiles.view.others',
        ]);

        // Able to view applications and vote on them once they reach the right stage, but not approve applications up to said stage
        $reviewer->givePermissionTo([
            'applications.view.all',
            'applications.vote',
        ]);

        $hiringManager->givePermissionTo('appointments.*', 'applications.*', 'admin.hiring.*');

        $admin->givePermissionTo([
            'appointments.*',
            'admin.userlist',
            'admin.stafflist',
            'admin.hiring.*',
            'admin.notificationsettings.*',
            'profiles.view.others',
            'profiles.edit.others',
            'admin.maintenance.logs.view',
        ]);
    }
}
