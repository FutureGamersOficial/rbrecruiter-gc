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
        $staffUsers = [

            [
                'uuid' => 'd2b321b56ff1445db9d7794701983cad',
                'name' => 'Robot 1',
                'email' => 'tester1@example.com',
                'username' => 'tester1',
                'originalIP' => '99.18.146.235',
                'password' => Hash::make('password'),
            ],
            [
                'uuid' => 'ab22b5da02644953ace969fce85c0819',
                'name' => 'Robot 2',
                'email' => 'tester2@example.com',
                'username' => 'tester2',
                'originalIP' => '141.239.229.53',
                'password' => Hash::make('password'),
            ],
            [
                'uuid' => 'df38e6bf762944d3a600ded59a693ad1',
                'name' => 'Robot 3',
                'email' => 'tester3@example.com',
                'username' => 'tester3',
                'originalIP' => '25.63.20.97',
                'password' => Hash::make('password'),
            ],
            [
                'uuid' => '689e446484824f6bad5064e3df0aaa96',
                'name' => 'Robot 4',
                'email' => 'tester4@example.com',
                'username' => 'tester4',
                'originalIP' => '220.105.223.142',
                'password' => Hash::make('password'),
            ],
            [
                'uuid' => '172391f917bf418ab1c40ebc041ed5ba',
                'name' => 'Robot 5',
                'email' => 'tester5@example.com',
                'username' => 'tester5',
                'originalIP' => '224.66.76.60',
                'password' => Hash::make('password'),
            ],
            [
                'uuid' => '371f34dcce2a4457bf385ab9417a2345',
                'name' => 'Robot 6',
                'email' => 'tester6@example.com',
                'username' => 'tester6',
                'originalIP' => '97.113.131.0',
                'password' => Hash::make('password'),
            ],
            [
                'uuid' => '89aa5222855542bebe7a7780248ef5f9',
                'name' => 'Robot 7',
                'email' => 'tester7@example.com',
                'username' => 'tester7',
                'originalIP' => '15.160.137.222',
                'password' => Hash::make('password'),
            ],

        ];

        $regularUsers = [

            [
                'uuid' => '20f69f47e72f463493b5b91d1c05452f',
                'name' => 'User 1',
                'email' => 'user1@example.com',
                'username' => 'user1',
                'originalIP' => '253.25.237.78',
                'password' => Hash::make('password'),
            ],
            [
                'uuid' => '5f900018241e4aaba7883f2d5c5c2357',
                'name' => 'User 2',
                'email' => 'user2@example.com',
                'username' => 'user2',
                'originalIP' => '82.92.156.176',
                'password' => Hash::make('password'),
            ],
            [
                'uuid' => 'ba9780c3270745c6840eaabe1bf8aa14',
                'name' => 'User 3',
                'email' => 'user3@example.com',
                'username' => 'user3',
                'originalIP' => '224.123.129.17',
                'password' => Hash::make('password'),
            ],

        ];

        foreach ($regularUsers as $regularUser) {
            $user = User::create($regularUser);
            Profile::create([
                'profileShortBio' => 'Random data '.rand(0, 1000),
                'profileAboutMe' => 'Random data '.rand(0, 1000),
                'socialLinks' => '[]', // empty json set, not an array
                'avatarPreference' => 'gravatar',
                'userID' => $user->id,
            ]);
        }

        foreach ($staffUsers as $staffUser) {
            $user = User::create($staffUser);
            Profile::create([
                'profileShortBio' => 'Random data '.rand(0, 1000),
                'profileAboutMe' => 'Random data '.rand(0, 1000),
                'socialLinks' => '[]',
                'avatarPreference' => 'gravatar',
                'userID' => $user->id,
            ]);
        }

        User::create([
            'uuid' => '6102256abd284dd7b68e4c96ef313734',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'originalIP' => '192.168.1.2',
            'password' => Hash::make('password'),
        ]);

        foreach (User::all() as $user) {
            $user->assignRole('reviewer', 'user');
        }
    }
}
