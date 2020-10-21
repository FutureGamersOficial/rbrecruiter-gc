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

use App\Http\Requests\Add2FASecretRequest;
use Google2FA;
use Illuminate\Support\Facades\Log;

trait AuthenticatesTwoFactor
{
    public function verify2FA(Add2FASecretRequest $request)
    {
        $isValid = Google2FA::verifyKey($request->user()->twofa_secret, $request->otp);

        if ($isValid) {
            Google2FA::login();

            Log::info('SECURITY (postauth): One-time password verification succeeded', [
                'initiator' => $request->user()->email,
                'ip' => $request->ip(),
            ]);

            return redirect()->to($this->redirectTo);
        } else {
            Log::warning('SECURITY (preauth): One-time password verification failed', [
                'initiator' => $request->user()->email,
                'ip' => $request->ip(),
            ]);

            $request->session()->flash('error', 'Your one time password is invalid.');

            return redirect()->back();
        }
    }
}
