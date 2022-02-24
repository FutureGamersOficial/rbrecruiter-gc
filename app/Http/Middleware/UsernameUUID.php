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

namespace App\Http\Middleware;

use App\Facades\UUID;
use Closure;

class UsernameUUID
{
    /**
     * Converts a Minecraft username found in the request body to a UUID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();
        if (isset($input['uuid'])) {
            try {
                $username = $input['uuid'];
                $input['uuid'] = UUID::toUUID($username);
            } catch (\InvalidArgumentException $iae) {
                report($iae);

                $request->session()->flash('error', $iae->getMessage());

                return redirect(route('register'));
            }

            $request->replace($input);
        }

        return $next($request);
    }
}
