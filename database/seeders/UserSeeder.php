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

use App\Profile;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Rationale:
         *  A ghost account is an account used by deleted users.
         *  Essentially, when users are deleted, their content is re-assigned to the
         *  ghost account.
         *  Also used by one-off apps.
         *
         *  The ghost account was inspired by Github's ghost account.
         */
        $ghostAccount = User::create([
            'uuid' => 'b741345057274a519144881927be0290', // Ghost
            'name' => 'Ghost (deleted account)',
            'email' => 'blackhole@example.com',
            'email_verified_at' => now(),
            'username' => 'ghost',
            'originalIP' => '0.0.0.0',
            'password' => 'locked'
        ])->assignRole('user'); // There can't be role-less users


        $admin = User::create([
            'uuid' => '069a79f444e94726a5befca90e38aaf5', // Notch
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'username' => 'admin',
            'originalIP' => '0.0.0.0',
            'password' => Hash::make('password'),

        ])->assignRole([ // all privileges
            'user',
            'reviewer',
            'admin',
            'hiringManager',
        ]);

        $staffmember = User::create([
            'uuid' => '853c80ef3c3749fdaa49938b674adae6', // Jeb__
            'name' => 'Staff Member',
            'email' => 'staffmember@example.com',
            'email_verified_at' => now(),
            'username' => 'staffmember',
            'originalIP' => '0.0.0.0',
            'password' => Hash::make('password'),

        ])->assignRole([ // all privileges
            'user',
            'reviewer',
        ]);

        $user = User::create([
            'uuid' => 'f7c77d999f154a66a87dc4a51ef30d19', // hypixel
            'name' => 'End User',
            'email' => 'enduser@example.com',
            'email_verified_at' => now(),
            'username' => 'enduser',
            'originalIP' => '0.0.0.0',
            'password' => Hash::make('password'),

        ])->assignRole([ // all privileges
            'user',
        ]);

    }
}
