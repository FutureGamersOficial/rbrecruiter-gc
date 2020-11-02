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
            $reason = $request->reason;
            $duration = strtolower($request->durationOperator);
            $durationOperand = $request->durationOperand;

            $expiryDate = now();

            if (! empty($duration)) {
                switch ($duration) {
                    case 'days':
                        $expiryDate->addDays($durationOperand);
                        break;

                    case 'weeks':
                        $expiryDate->addWeeks($durationOperand);
                        break;

                    case 'months':
                        $expiryDate->addMonths($durationOperand);
                        break;

                    case 'years':
                        $expiryDate->addYears($durationOperand);
                        break;
                }
            } else {
                // Essentially permanent
                $expiryDate->addYears(5);
            }

            $ban = Ban::create([
                'userID' => $user->id,
                'reason' => $reason,
                'bannedUntil' => $expiryDate->format('Y-m-d H:i:s'),
                'userAgent' => 'Unknown',
                'authorUserID' => Auth::user()->id,
            ]);

            event(new UserBannedEvent($user, $ban));
            $request->session()->flash('success', 'User banned successfully! Ban ID:  #'.$ban->id);
        } else {
            $request->session()->flash('error', 'User already banned!');
        }

        return redirect()->back();
    }

    public function delete(Request $request, User $user)
    {
        $this->authorize('delete', $user->bans);

        if (! is_null($user->bans)) {
            $user->bans->delete();
            $request->session()->flash('success', 'User unbanned successfully!');
        } else {
            $request->session()->flash('error', 'This user isn\'t banned!');
        }

        return redirect()->back();
    }
}
