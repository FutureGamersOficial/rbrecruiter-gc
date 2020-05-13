<?php

namespace App\Http\Requests;

use App\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileSave extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Profile $profile
     * @return bool
     */
    public function authorize(Profile $profile)
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shortBio' => 'nullable|string|max:100',
            'aboutMe' => 'nullable|string|max:2000',
            'avatarPref' => 'required|string',
            'socialInsta' => 'nullable|string',
            'socialTwitter' => 'nullable|string',
            'socialDiscord' => 'nullable|string',
            'socialGithub' => 'nullable|string'
        ];
    }
}
