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

use App\Notifications\NewContact;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    protected $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    public function create(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $msg = $request->msg;

        $challenge = $request->input('captcha');

        // TODO: now: add middleware for this verification, move to invisible captcha
        $verifyrequest = Http::asForm()->post(config('recaptcha.verify.apiurl'), [
            'secret' => config('recaptcha.keys.secret'),
            'response' => $challenge,
            'remoteip' => $request->ip(),
        ]);

        $response = json_decode($verifyrequest->getBody(), true);

        if (! $response['success']) {
            $request->session()->flash('error', 'Beep beep boop... Robot? Submission failed.');

            return redirect()->back();
        }

        foreach (User::all() as $user) {
            if ($user->hasRole('admin')) {
                $user->notify(new NewContact(collect([
                    'message' => $msg,
                    'ip' => $request->ip(),
                    'email' => $email,
                ])));
            }
        }

        $request->session()->flash('success', 'Message sent successfully! We usually respond within 48 hours.');

        return redirect()->back();
    }
}
