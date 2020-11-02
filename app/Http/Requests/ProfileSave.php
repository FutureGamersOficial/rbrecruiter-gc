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

namespace App\Http\Requests;

use App\Profile;
use Illuminate\Foundation\Http\FormRequest;

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
            'socialGithub' => 'nullable|string',
        ];
    }
}
