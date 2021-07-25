<?php


namespace App\Services;


use App\Exceptions\ProfileNotFoundException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileService
{

    /**
     * @throws ProfileNotFoundException
     */
    public function updateProfile($userID, Request $request) {
        $profile = User::find($userID)->profile;
        $social = [];

        if (! is_null($profile)) {
            switch ($request->avatarPref) {
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

            return $profile->save();
        }

        throw new ProfileNotFoundException("This profile does not exist.");
    }

}
