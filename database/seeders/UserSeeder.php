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
            'uuid' => '069a79f444e94726a5befca90e38aaf5', // Notch
            'name' => 'Ghost (deleted account)',
            'email' => 'blackhole@spacejewel-hosting.com',
            'username' => 'ghost',
            'originalIP' => '0.0.0.0',
            'password' => 'locked' 
        ])->assignRole('user'); // There can't be role-less users


        $admin = User::create([
            'uuid' => '6102256abd284dd7b68e4c96ef313734',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'originalIP' => '217.1.189.34',
            'password' => Hash::make('password'),

        ])->assignRole([ // all privileges
            'user',
            'reviewer',
            'admin',
            'hiringManager',
            'developer'
        ]);

    }
}
