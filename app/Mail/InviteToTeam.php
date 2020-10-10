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

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Mpociot\Teamwork\TeamInvite;

class InviteToTeam extends Mailable
{
    use Queueable, SerializesModels;

    public $teamName;

    public $name;

    public $inviterName;

    public $denyToken;

    public $acceptToken;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TeamInvite $invite)
    {
        $this->teamName = $invite->team->name;
        $this->name = $invite->user->name;
        $this->inviterName = $invite->inviter->name;
        $this->acceptToken = $invite->accept_token;
        $this->denyToken = $invite->deny_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject('You have just been invited to '.$this->teamName)
                ->view('mail.invited-to-team');
    }
}
