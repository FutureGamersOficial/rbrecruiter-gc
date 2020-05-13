<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileSave;
use Illuminate\Support\Facades\Log;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfile()
    {

        $socialMediaProfiles = json_decode(Auth::user()->profile->socialLinks, true);

        return view('dashboard.user.profile.userprofile')
            ->with([
                'profile' => Auth::user()->profile,
                'github' => $socialMediaProfiles['links']['github'] ?? 'UpdateMe',
                'twitter' => $socialMediaProfiles['links']['twitter'] ?? 'UpdateMe',
                'insta' => $socialMediaProfiles['links']['insta'] ?? 'UpdateMe',
                'discord' => $socialMediaProfiles['links']['discord'] ?? 'UpdateMe#12345',
            ]);

    }

    public function saveProfile(ProfileSave $request)
    {
        // TODO: Implement profile security policy for logged in users

        $profile = Profile::find(Auth::user()->id);
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

            $profile->save();

            $request->session()->flash('success', 'Profile settings saved successfully.');

        }
        else
        {
            $gm = 'Guru Meditation #' . rand(0, 1000);
            Log::alert('[GURU MEDITATION]: Could not find profile for authenticated user ' . Auth::user()->name . 'whilst trying to update it! Please verify that profiles are being created automatically during signup.',
            [
                'uuid' => Auth::user()->uuid,
                'timestamp' => now(),
                'route' => $request->route()->getName(),
                'gmcode' => $gm // If this error is reported, the GM code, denoting a severe error, will help us find this entry in the logs

            ]);
            $request->session()->flash('error', 'A technical error has occurred whilst trying to save your profile. Incident details have been recorded. Please report this incident to administrators with the following case number:  ' . $gm);
        }

        return redirect()->back();

    }

}
