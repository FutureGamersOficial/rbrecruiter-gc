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
use App\Services\AccountSuspensionService;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Facades\IP;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as protected originalAttemptLogin;
    }

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    // We can't customise the error message, since that would imply overriding the login method, which is large.
    // Also, the user should never know that they're banned.
    public function attemptLogin(Request $request): bool
    {
        $service = new AccountSuspensionService;
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $isBanned = $service->isSuspended($user);
            $isLocked = $service->isLocked($user);

            if ($isBanned || $isLocked) {
                return false;
            } else {
                return $this->originalAttemptLogin($request);
            }
        }

        return $this->originalAttemptLogin($request);
    }

    public function authenticated(Request $request, User $user)
    {
        if (IP::shouldCollect()) {
            if ($user->originalIP !== $request->ip())
            {
                Log::alert('User IP address changed from last login. Updating.', [
                    'prev' => $user->originalIP,
                    'new' => $request->ip()
                ]);
                $user->originalIP = $request->ip();
                $user->save();
            }
        }
    }

    public function discordRedirect() {
        return Socialite::driver('discord')->redirect();
    }

    public function discordCallback() {
        // TODO;
    }
}
