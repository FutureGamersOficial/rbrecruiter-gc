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

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'teams.user.view.own',
        ]);

        Permission::create([
            'name' => 'teams.admin.view.all',
        ]);

        // Has access to the teams feature
        Permission::create([
            'name' => 'teams.view',
        ]);

        Permission::create([
            'name' => 'teams.admin.create',
        ]);
        Permission::create([
            'name' => 'teams.admin.delete',
        ]);
        Permission::create([
            'name' => 'teams.user.join',
        ]);
        Permission::create([
            'name' => 'teams.user.leave',
        ]);
        Permission::create([
            'name' => 'teams.admin.vacancies.assign',
        ]);
        Permission::create([
            'name' => 'teams.admin.vacancies.unassign',
        ]);
        Permission::create([
            'name' => 'teams.admin.applications.changeteam',
        ]);
        Permission::create([
            'name' => 'teams.members.groupchat',
        ]);
    }
}
