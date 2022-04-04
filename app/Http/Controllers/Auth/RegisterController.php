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

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use App\Facades\Options;
use App\Facades\IP;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $users = User::where('originalIP', \request()->ip())->get();

        foreach ($users as $user) {
            if ($user && $user->isBanned()) {
                abort(403, 'You do not have permission to access this page.');
            }
        }

        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $password = ['required', 'string', 'confirmed'];

        switch (Options::getOption('pw_security_policy'))
        { // this could be better structured, switch doesn't feel right
            case 'off':
                $password = ['required', 'string', 'confirmed'];
                break;
            case 'low':
                $password = ['required', 'string', 'min:10', 'confirmed'];
                break;

            case 'medium':
                $password = ['required', 'string', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{12,}$/'];
                break;

            case 'high':
                $password = ['required', 'string', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{20,}$/'];
        }

        return Validator::make($data, [
            'uuid' => (Options::getOption('requireGameLicense') && Options::getOption('currentGame') == 'MINECRAFT') ? ['required', 'string', 'unique:users', 'min:32', 'max:32'] : ['nullable', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'acceptTerms' => ['required', 'accepted'],
            'password' => $password,
        ], [
            'uuid.required' => 'Please enter a valid (and Premium) Minecraft username! We do not support cracked users.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'uuid' => $data['uuid'] ?? "disabled",
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'originalIP' => IP::shouldCollect() ? request()->ip() : '0.0.0.0',
        ]);

        $user->assignRole('user');

        return $user;
    }
}
