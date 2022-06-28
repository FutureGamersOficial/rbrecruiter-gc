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
use App\Facades\IP;
use App\Http\Requests\Add2FASecretRequest;
use App\Http\Requests\BanUserRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\FlushSessionsRequest;
use App\Http\Requests\Remove2FASecretRequest;
use App\Http\Requests\SearchPlayerRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Notifications\ChangedPassword;
use App\Notifications\EmailChanged;
use App\Services\AccountSuspensionService;
use App\Traits\DisablesFeatures;
use App\Traits\HandlesAccountDeletion;
use App\Traits\ReceivesAccountTokens;
use App\User;
use Google2FA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use HandlesAccountDeletion, DisablesFeatures;


    /**
     * Shows list of users
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUsers()
    {
        $this->authorize('viewPlayers', User::class);

        return view('dashboard.administration.players')
            ->with([
                'users' => User::with('roles')->paginate('6'),
                'numUsers' => count(User::all()),
                'bannedUserCount' => Ban::all()->count(),
            ]);
    }


    /**
     * Searches for a player with the given search query.
     *
     * @deprecated Until Algolia implementation
     * @param SearchPlayerRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showPlayersLike(SearchPlayerRequest $request)
    {
        $this->authorize('viewPlayers', User::class);

        $searchTerm = $request->searchTerm;
        $matchingUsers = User::query()
            ->where('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
            ->paginate(6);

        if (! $matchingUsers->isEmpty()) {
            $request->session()->flash('success', __('There were :usersCount user(s) matching your search.', ['usersCount' => $matchingUsers->count()]));

            return view('dashboard.administration.players')
            ->with([
                'users' => $matchingUsers,
                'numUsers' => count(User::all()),
                'bannedUserCount' => Ban::all()->count(),
            ]);
        } else {
            $request->session()->flash('error', __('Your search term did not return any results.'));

            return redirect(route('registeredPlayerList'));
        }
    }


    /**
     * Shows the user account's settings page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public function showAccount(Request $request)
    {
        $QRCode = null;

        if (! $request->user()->has2FA()) {
            if ($request->session()->has('twofaAttemptFailed')) {
                $twoFactorSecret = $request->session()->get('current2FA');
            } else {
                $twoFactorSecret = Google2FA::generateSecretKey(32, '');
                $request->session()->put('current2FA', $twoFactorSecret);
            }

            $QRCode = Google2FA::getQRCodeInline(
              config('app.name'),
              $request->user()->email,
              $twoFactorSecret
            );
        }

        return view('dashboard.user.profile.useraccount')
            ->with('ip', request()->ip())
            ->with('twofaQRCode', $QRCode);
    }


    /**
     * Show account management screen
     *
     * @param AccountSuspensionService $suspensionService
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showAcocuntManagement(AccountSuspensionService $suspensionService, Request $request, User $user)
    {

        $this->authorize('adminEdit', $user);

        $systemRoles = Role::all()->pluck('name')->all();
        $userRoles = $user->roles->pluck('name')->all();

        $roleList = [];

        foreach ($systemRoles as $role) {
            if (in_array($role, $userRoles)) {
                $roleList[$role] = true;
            } else {
                $roleList[$role] = false;
            }
        }

        return view('dashboard.user.manage')
            ->with([
               'user' =>  $user,
                'roles' => $roleList,
                'ipInfo' => IP::lookup($request->ip())
            ]);
    }

    /**
     * Log out other sessions for the current user
     *
     * @param FlushSessionsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function flushSessions(FlushSessionsRequest $request)
    {
        // TODO: Move all log calls to a listener, which binds to an event fired by each significant event, such as this one
        // This will allow for other actions to be performed on certain events (like login failed event)

        Auth::logoutOtherDevices($request->currentPasswordFlush);
        Log::notice('User '.Auth::user()->name.' has logged out other devices in their account',
        [
            'originIPAddress' => $request->ip(),
            'userID' => Auth::user()->id,
            'timestamp' => now(),
        ]);

        $request->session()->flash('success', __('Successfully logged out other devices. Remember to change your password if you think you\'ve been compromised.'));

        return redirect()->back();
    }



    /**
     * Change the current user's password
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        if (config('demo.is_enabled')) {
            return redirect()
                ->back()
                ->with('error', __('This feature is disabled'));
        }
        $user = User::find(Auth::user()->id);

        if (! is_null($user)) {
            $user->password = Hash::make($request->newPassword);
            $user->password_last_updated = now();

            $user->save();

            Log::info('User '.$user->name.' has changed their password', [
                'originIPAddress' => $request->ip(),
                'userID' => $user->id,
                'timestamp' => now(),
            ]);
            $user->notify(new ChangedPassword());

            Auth::logout();

            return redirect()->back();
        }
    }



    /**
     * Change the current user's email address
     *
     * @param ChangeEmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeEmail(ChangeEmailRequest $request)
    {
       $this->disable();

        $user = User::find(Auth::user()->id);

        if (! is_null($user)) {
            $user->email = $request->newEmail;
            $user->save();

            Log::notice('User '.$user->name.' has just changed their contact email address', [
                'originIPAddress' => $request->ip(),
                'userID' => $user->id,
                'timestamp' => now(),
            ]);
            $user->notify(new EmailChanged());

            $request->session()->flash('success', __('Your email address has been changed!'));
        } else {
            $request->session()->flash('error', __('There has been an error whilst trying to update your account. Please contact administrators.'));
        }

        return redirect()->back();
    }


    /**
     * Delete the given user's account
     *
     * @param DeleteUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(DeleteUserRequest $request, User $user)
    {
        $this->disable();

        $this->authorize('delete', $user);

        if ($request->confirmPrompt == 'DELETE ACCOUNT') {
            $user->delete();
            $request->session()->flash('success', __('User deleted successfully.'));
        } else {
            $request->session()->flash('error', __('Wrong confirmation text! Try again.'));
        }

        return redirect()->route('registeredPlayerList');
    }


    /**
     * Update a given user's details
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('adminEdit', $user);
        $this->disable();

        // Mass update would not be possible here without extra code, making route model binding useless
        $user->email = $request->email;
        $user->name = $request->name;
        $user->uuid = $request->uuid;

        $existingRoles = Role::all()
            ->pluck('name')
            ->all();

        $roleDiff = array_diff($existingRoles, $request->roles);

        // Adds roles that were selected. Removes roles that aren't selected if the user has them.
        foreach ($roleDiff as $deselectedRole) {
            if ($user->hasRole($deselectedRole) && $deselectedRole !== 'user') {
                $user->removeRole($deselectedRole);
            }
        }

        foreach ($request->roles as $role) {
            if (! $user->hasRole($role)) {
                $user->assignRole($role);
            }
        }

        $user->save();
        $request->session()->flash('success', __('User updated successfully!'));

        return redirect()->back();
    }


    /**
     * Generate and add a 2FA secret for the current user
     *
     * @param Add2FASecretRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public function add2FASecret(Add2FASecretRequest $request)
    {
        if (config('demo.is_enabled')) {
            return redirect()
                ->back()
                ->with('error', __('This feature is disabled'));
        }

        $currentSecret = $request->session()->get('current2FA');
        $isValid = Google2FA::verifyKey($currentSecret, $request->otp);

        if ($isValid) {
            $request->user()->twofa_secret = $currentSecret;
            $request->user()->save();

            Log::warning('SECURITY: User activated two-factor authentication', [
                'initiator' => $request->user()->email,
                'ip' => $request->ip(),
            ]);

            Google2FA::login();

            Log::warning('SECURITY: Started two factor session automatically', [
                'initiator' => $request->user()->email,
                'ip' => $request->ip(),
            ]);

            $request->session()->forget('current2FA');

            if ($request->session()->has('twofaAttemptFailed')) {
                $request->session()->forget('twofaAttemptFailed');
            }

            $request->session()->flash('success', __('2FA succesfully enabled! You\'ll now be prompted for an OTP each time you log in.'));
        } else {
            $request->session()->flash('error', __('Incorrect code. Please reopen the 2FA settings panel and try again.'));
            $request->session()->put('twofaAttemptFailed', true);
        }

        return redirect()->back();
    }


    /**
     * Remove the current user's two factor secret key
     *
     * @param Remove2FASecretRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove2FASecret(Remove2FASecretRequest $request)
    {
        Log::warning('SECURITY: Disabling two factor authentication (user initiated)', [
            'initiator' => $request->user()->email,
            'ip' => $request->ip(),
        ]);

        $request->user()->twofa_secret = null;
        $request->user()->save();

        $request->session()->flash('success', __('Two-factor authentication disabled.'));

        return redirect()->back();
    }


    /**
     * Demote the given user's privileges
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function terminate(Request $request, User $user)
    {
        $this->authorize('terminate', User::class);
        if (config('demo.is_enabled')) {
            return redirect()
                ->back()
                ->with('error', __('This feature is disabled'));
        }

        // TODO: move logic to policy
        if (! $user->isStaffMember() || $user->is(Auth::user())) {
            $request->session()->flash('error', __('You cannot terminate this user.'));

            return redirect()->back();
        }

        foreach ($user->roles as $role) {
            if ($role->name == 'user') {
                continue;
            }

            $user->removeRole($role->name);
        }

        Log::info('User '.$user->name.' has just been demoted.');
        $request->session()->flash('success', __('User terminated successfully.'));

        //TODO: Dispatch event
        return redirect()->back();
    }

    /**
     * Suspend the given user
     *
     * @param AccountSuspensionService $suspensionService
     * @param BanUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function suspend(AccountSuspensionService $suspensionService, BanUserRequest $request, User $user)
    {
        $this->authorize('create', [Ban::class, $user]);
        $this->disable();

        if (!$suspensionService->isSuspended($user)) {

            $suspensionService->suspend($request->reason, $request->duration, $user, $request->suspensionType);
            $request->session()->flash('success', __('Account suspended.'));

        } else {

            $request->session()->flash('error', __('Account already suspended!'));
        }

        return redirect()->back();
    }

    /**
     * Unsuspend the given user
     *
     * @param AccountSuspensionService $suspensionService
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unsuspend(AccountSuspensionService $suspensionService, Request $request, User $user)
    {
        $this->authorize('delete', $user->bans);
        $this->disable();

        if ($suspensionService->isSuspended($user)) {

            $suspensionService->unsuspend($user);
            $request->session()->flash('success', __('Account unsuspended successfully!'));

        } else {
            $request->session()->flash('error', __('This account isn\'t suspended!'));
        }

        return redirect()->back();
    }

}
