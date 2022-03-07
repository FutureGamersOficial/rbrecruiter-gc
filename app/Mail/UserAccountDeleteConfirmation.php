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

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAccountDeleteConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public string
        $approveLink,
        $cancelLink,
        $name,
        $userID;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, array $links)
    {
        $this->approveLink = $links['approveURL'];
        $this->cancelLink = $links['cancelURL'];

        $this->name = $user->name;
        $this->userID = $user->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[ACTION REQUIRED] Please confirm account removal')
            ->view('mail.deleted-account');
    }
}
