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

namespace App\Traits;

use App\Http\Requests\UserDeleteRequest;
use App\Mail\UserAccountDeleteConfirmation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait ReceivesAccountTokens
{
    public function userDelete(UserDeleteRequest $request)
    {
        // a little verbose
        $user = User::find(Auth::user()->id);
        $tokens = $user->generateAccountTokens();

        Mail::to($user)->send(new UserAccountDeleteConfirmation($user, $tokens, $request->ip()));

        $user->delete();
        Auth::logout();

        $request->session()->flash('success', __('Please check your email to finish deleting your account.'));

        return redirect()->to('/');
    }

    public function processDeleteConfirmation(Request $request, $ID, $action, $token)
    {
        // We can't rely on Laravel's route model injection, because it'll ignore soft-deleted models,
        // so we have to use a special scope to find them ourselves.
        $user = User::withTrashed()->findOrFail($ID);
        $email = $user->email;

        switch ($action) {
            case 'confirm':

                if ($user->verifyAccountToken($token, 'deleteToken')) {
                    Log::info('SECURITY: User deleted account!', [

                        'confirmDeleteToken' => $token,
                        'ipAddress' => $request->ip(),
                        'email' => $user->email,

                    ]);

                    $user->forceDelete();

                    $request->session()->flash('success', __('Account permanently deleted. Thank you for using our service.'));

                    return redirect()->to('/');
                }

                break;

            case 'cancel':

                if ($user->verifyAccountToken($token, 'cancelToken')) {
                    $user->restore();
                    $request->session()->flash('success', __('Account deletion cancelled! You may now login.'));

                    return redirect()->to(route('login'));
                }

                break;

            default:

                abort(404, __('The page you were trying to access may not exist or may be expired.'));
        }
    }
}
