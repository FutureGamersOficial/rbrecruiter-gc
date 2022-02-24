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

use Illuminate\Support\Facades\Hash;

trait HandlesAccountTokens
{
    public function generateAccountTokens()
    {
        $deleteToken = bin2hex(openssl_random_pseudo_bytes(32));
        $cancelToken = bin2hex(openssl_random_pseudo_bytes(32));

        $tokens = [

            'delete' => Hash::make($deleteToken),
            'cancel' => Hash::make($cancelToken),

        ];

        $this->account_tokens = json_encode($tokens);
        $this->save();

        return [

            'delete' => $deleteToken,
            'cancel' => $cancelToken,
        ];
    }

    public function verifyAccountToken(string $token, string $type): bool
    {
        $tokens = json_decode($this->account_tokens);

        if ($type == 'deleteToken') {
            return Hash::check($token, $tokens->delete);
        } elseif ($type == 'cancelToken') {
            return Hash::check($token, $tokens->cancel);
        }

        return false;
    }
}
