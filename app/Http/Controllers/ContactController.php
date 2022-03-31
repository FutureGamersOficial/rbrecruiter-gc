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

use App\Exceptions\FailedCaptchaException;
use App\Http\Requests\HomeContactRequest;
use App\Notifications\NewContact;
use App\Services\ContactService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    protected $users;

    private $contactService;

    public function __construct(User $users, ContactService $contactService)
    {
        $this->contactService = $contactService;
        $this->users = $users;
    }

    public function create(HomeContactRequest $request)
    {
        try {

            $email = $request->email;
            $msg = $request->msg;
            $challenge = $request->input('captcha');

            $this->contactService->sendMessage($request->ip(), $msg, $email, $challenge);

            return redirect()
                ->back()
                ->with('success',__('Message sent successfully! We usually respond within 48 hours.'));

        } catch (FailedCaptchaException $ex) {
            return redirect()
                ->back()
                ->with('error', $ex->getMessage());
        }
    }
}
