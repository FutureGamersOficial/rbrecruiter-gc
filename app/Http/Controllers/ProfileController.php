<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileSave;
use Illuminate\Support\Facades\Log;
use App\Profile;
use App\User;
use App\Facades\IP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{

  public function index()
  {

    return view('dashboard.user.directory')
          ->with('users', User::with('profile', 'bans')->paginate(9));
  }

    public function showProfile()
    {

        $socialLinks = Auth::user()->profile->socialLinks ?? "[]";
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

    // Route model binding
    public function showSingleProfile(Request $request, User $user)
    {

        $socialMediaProfiles = json_decode($user->profile->socialLinks, true);
        $createdDate = Carbon::parse($user->created_at);

        $systemRoles = Role::all()->pluck('name')->all();
        $userRoles = $user->roles->pluck('name')->all();

        $roleList = [];


        foreach($systemRoles as $role)
        {
          if (in_array($role, $userRoles))
          {
            $roleList[$role] = true;
          }
          else
          {
            $roleList[$role] = false;
          }
        }

        if (Auth::user()->is($user) || Auth::user()->can('profiles.view.others'))
        {
            return view('dashboard.user.profile.displayprofile')
                ->with([
                    'profile' => $user->profile,
                    'github' => $socialMediaProfiles['links']['github'] ?? 'UpdateMe',
                    'twitter' => $socialMediaProfiles['links']['twitter'] ?? 'UpdateMe',
                    'insta' => $socialMediaProfiles['links']['insta'] ?? 'UpdateMe',
                    'discord' => $socialMediaProfiles['links']['discord'] ?? 'UpdateMe#12345',
                    'since' => $createdDate->englishMonth . " " . $createdDate->year,
                    'ipInfo' => IP::lookup($user->originalIP),
                    'roles' => $roleList
                ]);
        }
        else
        {
            abort(403, 'You cannot view someone else\'s profile.');
        }

    }

    public function saveProfile(ProfileSave $request)
    {
        $profile = User::find(Auth::user()->id)->profile;
        $social = [];

        if (!is_null($profile))
        {
            switch ($request->avatarPref)
            {
                case 'MOJANG':
                    $avatarPref = 'crafatar';

                    break;
                case 'GRAVATAR':
                    $avatarPref = strtolower($request->avatarPref);

                    break;
            }

            $social['links']['github'] = $request->socialGithub;
            $social['links']['twitter'] = $request->socialTwitter;
            $social['links']['insta'] = $request->socialInsta;
            $social['links']['discord'] = $request->socialDiscord;

            $profile->profileShortBio = $request->shortBio;
            $profile->profileAboutMe = $request->aboutMe;
            $profile->avatarPreference = $avatarPref;
            $profile->socialLinks = json_encode($social);

            $newProfile = $profile->save();

            $request->session()->flash('success', 'Profile settings saved successfully.');

        }

        return redirect()->back();

    }

}
