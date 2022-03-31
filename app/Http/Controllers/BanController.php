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
use App\Services\AccountSuspensionService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanController extends Controller
{

    protected $suspensionService;

    public function __construct(AccountSuspensionService $suspensionService)
    {
        // Inject the service via DI
        $this->suspensionService = $suspensionService;
    }

    public function insert(BanUserRequest $request, User $user)
    {
        if (config('demo.is_enabled')) {
            return redirect()
                ->back()
                ->with('error', __('This feature is disabled'));
        }

        $this->authorize('create', [Ban::class, $user]);


        if (!$this->suspensionService->isSuspended($user)) {

            $this->suspensionService->suspend($request->reason, $request->duration, $user, $request->suspensionType);
            $request->session()->flash('success', __('Account suspended.'));

        } else {

            $request->session()->flash('error', __('Account already suspended!'));
        }

        return redirect()->back();
    }

    public function delete(Request $request, User $user)
    {
        if (config('demo.is_enabled')) {
            return redirect()
                ->back()
                ->with('error', __('This feature is disabled'));
        }

        $this->authorize('delete', $user->bans);

        if ($this->suspensionService->isSuspended($user)) {

            $this->suspensionService->unsuspend($user);
            $request->session()->flash('success', __('Account unsuspended successfully!'));

        } else {
            $request->session()->flash('error', __('This account isn\'t suspended!'));
        }

        return redirect()->back();
    }
}
