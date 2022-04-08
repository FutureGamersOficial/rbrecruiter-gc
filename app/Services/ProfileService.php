<?php


namespace App\Services;


use App\Exceptions\ProfileAlreadyExistsException;
use App\Exceptions\ProfileCreationFailedException;
use App\Exceptions\ProfileNotFoundException;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileService
{

    /**
     * Creates a new profile for the specified $targetUser.
     *
     * @param User $targetUser The user to create the profile for.
     * @return bool
     * @throws ProfileAlreadyExistsException
     * @throws ProfileCreationFailedException
     */
    public function createProfile(User $targetUser): Profile {

        if (is_null($targetUser->profile)) {

            $profile = Profile::create([

                'profileShortBio' => 'Write a one-liner about you here!',
                'profileAboutMe' => 'Tell us a bit about you.',
                'socialLinks' => '{}',
                'userID' => $targetUser->id,

            ]);

            if (is_null($profile)) {
                throw new ProfileCreationFailedException(__('Could not create profile! Please try again later.'));
            }

            Log::info('Created profile for new user', [
                'userid' => $targetUser->id
            ]);

            return $profile;
        }

        throw new ProfileAlreadyExistsException(__('Profile already exists!'));
    }

    /**
     * Updates the user's profile.
     *
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

    /**
     * Delete specified user's profile
     *
     * @param User $targetUser
     * @return bool
     * @throws ProfileNotFoundException
     */
    public function deleteProfile(User $targetUser): bool
    {

        if (!is_null($targetUser->profile)) {

            Log::alert('Deleted user profile', [
                'userid' => $targetUser->id
            ]);

            return $targetUser->profile->delete();
        }

        throw new ProfileNotFoundException(__('Attempting to delete non-existant profile!'));
    }

}
