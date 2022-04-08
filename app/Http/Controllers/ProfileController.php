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

use App\Facades\IP;
use App\Http\Requests\ProfileSave;
use App\Services\ProfileService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    private $profileService;

    public function __construct(ProfileService $profileService) {
        $this->profileService = $profileService;
    }

    public function index()
    {
        return view('dashboard.user.directory')
          ->with('users', User::with('profile', 'bans')->paginate(9));
    }

    public function showProfile()
    {
        // TODO: Come up with cleaner social media solution, e.g. social media object
        $socialLinks = Auth::user()->profile->socialLinks ?? '[]';
        $socialMediaProfiles = json_decode($socialLinks, true);

        return view('dashboard.user.profile.userprofile')
            ->with([
                'profile' => Auth::user()->profile,
                'github' => $socialMediaProfiles['links']['github'] ?? 'UpdateMe',
                'twitter' => $socialMediaProfiles['links']['twitter'] ?? 'UpdateMe',
                'insta' => $socialMediaProfiles['links']['insta'] ?? 'UpdateMe',
                'discord' => $socialMediaProfiles['links']['discord'] ?? 'UpdateMe#12345',
            ]);
    }

    public function showSingleProfile(User $user)
    {

        if (is_null($user->profile)) {

            return redirect()
                ->back()
                ->with('error', "This user doesn't have a profile.");

        }

        $socialMediaProfiles = json_decode($user->profile->socialLinks, true);
        $createdDate = Carbon::parse($user->created_at);

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

        $suspensionInfo = null;
        if ($user->isBanned())
        {
            $suspensionInfo = [

                'isPermanent' => $user->bans->isPermanent,
                'reason' => $user->bans->reason,
                'bannedUntil' => $user->bans->bannedUntil
            ];
        }

        if (Auth::user()->is($user) || Auth::user()->can('profiles.view.others')) {
            return view('dashboard.user.profile.displayprofile')
                ->with([
                    'profile' => $user->profile,
                    'github' => $socialMediaProfiles['links']['github'] ?? 'UpdateMe',
                    'twitter' => $socialMediaProfiles['links']['twitter'] ?? 'UpdateMe',
                    'insta' => $socialMediaProfiles['links']['insta'] ?? 'UpdateMe',
                    'discord' => $socialMediaProfiles['links']['discord'] ?? 'UpdateMe#12345',
                    'since' => $createdDate->englishMonth.' '.$createdDate->year,
                    'ipInfo' => IP::lookup($user->originalIP),
                    'roles' => $roleList,
                    'suspensionInfo' => $suspensionInfo
                ]);
        } else {
            abort(403, __('You cannot view someone else\'s profile.'));
        }
    }

    public function saveProfile(ProfileSave $request)
    {
        $this->profileService->updateProfile(Auth::user()->id, $request);
        return redirect()
            ->back()
            ->with('success', __('Profile updated.'));
    }
}
