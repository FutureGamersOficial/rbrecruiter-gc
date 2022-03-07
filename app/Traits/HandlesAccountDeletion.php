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
use App\Jobs\ProcessAccountDelete;
use App\Mail\UserAccountDeleteConfirmation;
use App\Services\AccountSuspensionService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

trait HandlesAccountDeletion
{

    /**
     * Starts the user account deletion process.
     *
     * @param AccountSuspensionService $suspensionService
     * @param UserDeleteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userDelete(AccountSuspensionService $suspensionService, UserDeleteRequest $request)
    {
        if (config('demo.is_enabled'))
        {
            return redirect()
                ->back()
                ->with('error', 'This feature is disabled');
        }

        $links = [
            'approveURL' => URL::temporarySignedRoute(
                'processDeleteConfirmation', now()->addDays(7), ['accountID' => $request->user()->id, 'action' => 'confirm']
            ),
            'cancelURL' => URL::temporarySignedRoute(
                'processDeleteConfirmation', now()->addDays(7), ['accountID' => $request->user()->id, 'action' => 'cancel']
            )
        ];

        Mail::to($request->user())
            ->send(new UserAccountDeleteConfirmation($request->user(), $links));

        // Only locked accounts can be deleted
        $suspensionService->lockAccount($request->user());
        Auth::logout();

        $request->session()->flash('success', __('Please check your email to finish deleting your account.'));
        return redirect()->to('/');
    }


    /**
     * Dispatches the correct jobs and events to delete the specified user account
     *
     * @param Request $request
     * @param AccountSuspensionService $suspensionService
     * @param $accountID
     * @param $action
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function processDeleteConfirmation(Request $request, AccountSuspensionService $suspensionService, $accountID, $action)
    {
        if (config('demo.is_enabled') || !$request->hasValidSignature())
        {
           abort(403);
        }

        // It's almost impossible for this to fail, unless the model has already been deleted by someone else, because:
        // The request URL can't be tampered with and the request can't be initiated without a valid account in the first place
        $account = User::find($accountID);

        if (!is_null($account))
        {
            if (!$suspensionService->isLocked($account)) {
                abort(403);
            }

            Log::alert('Signed account deletion request received!', [
                'user' => $account->name,
                'email' => $account->name,
                'created_at' => $account->created_at,
                'updated_at' => $account->updated_at,
                'deleted_at' => Carbon::now(),
                'ipAddress' => $request->ip(),
                'userAgent' => $request->userAgent(),

            ]);

            if ($action == 'confirm') {
                // dispatch event (for notifications) and job (for async processing)
                ProcessAccountDelete::dispatch($account);

                $request->session()->flash('success', __('Thank you for confirming. Your account will now be deleted shortly.'));

                return redirect()
                    ->to('/');
            }

            $suspensionService->unlockAccount($account);
            $request->session()->flash('success', __('Account removal request cancelled. Your account has been unlocked and you can now sign in.'));

            return redirect()
                ->route('login');

        }

        Log::error("Cannot delete account that doesn't exist!", [
            'validSignature' => $request->hasValidSignature()
        ]);
        abort(400);

    }
}
