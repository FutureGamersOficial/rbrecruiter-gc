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

        //
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

        Permission::create(['name' => 'applications.submit']);
        Permission::create(['name' => 'applications.stages.deny']);
        Permission::create(['name' => 'applications.stages.approve']);
        Permission::create(['name' => 'applications.view.all']);
        Permission::create(['name' => 'applications.view.own']);
        Permission::create(['name' => 'applications.vote']);
        Permission::create(['name' => 'appointments.schedule']);
        Permission::create(['name' => 'appointments.schedule.edit']);
        Permission::create(['name' => 'appointments.schedule.cancel']);
        Permission::create(['name' => 'applications.*']);
        Permission::create(['name' => 'appointments.*']);

        Permission::create(['name' => 'profiles.view.others']);
        Permission::create(['name' => 'profiles.edit.others']);

        Permission::create(['name' => 'admin.userlist']);
        Permission::create(['name' => 'admin.stafflist']);
        Permission::create(['name' => 'admin.hiring.forms']);
        Permission::create(['name' => 'admin.hiring.formbuilder']);
        Permission::create(['name' => 'admin.hiring.vacancy']);
        Permission::create(['name' => 'admin.hiring.vacancy.edit,delete']);
        Permission::create(['name' => 'admin.notificationsettings']);
        Permission::create(['name' => 'admin.notificationsettings.edit']);
        Permission::create(['name' => 'admin.hiring.*']);
        Permission::create(['name' => 'admin.notificationsettings.*']);
        Permission::create(['name' => 'admin.maintenance.logs.view']);

        Permission::create(['name' => 'admin.developertools.use']);

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
