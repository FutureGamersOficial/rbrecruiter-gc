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

namespace App\Http\Controllers;

use App\Ban;
use App\Events\UserBannedEvent;
use App\Http\Requests\BanUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanController extends Controller
{
    public function insert(BanUserRequest $request, User $user)
    {
        $this->authorize('create', [Ban::class, $user]);


        if (is_null($user->bans)) {

            $duration = $request->duration;
            $reason = $request->reason;
            $type = $request->suspensionType; // ON: Temporary | OFF: Permanent

            if ($type == "on") {
                $expiryDate = now()->addDays($duration);
            }

            $ban = Ban::create([
                'userID' => $user->id,
                'reason' => $reason,
                'bannedUntil' => ($type == "on") ? $expiryDate->format('Y-m-d H:i:s') : null,
                'authorUserID' => Auth::user()->id,
                'isPermanent' => ($type == "off") ? true : false
            ]);

            $request->session()->flash('success', __('Account suspended.'));
        } else {
            $request->session()->flash('error', __('Account already suspended!'));
        }

        return redirect()->back();
    }

    public function delete(Request $request, User $user)
    {
        $this->authorize('delete', $user->bans);

        if (! is_null($user->bans)) {
            $user->bans->delete();
            $request->session()->flash('success', __('User unsuspended successfully!'));
        } else {
            $request->session()->flash('error', __('This user isn\'t suspended!'));
        }

        return redirect()->back();
    }
}
