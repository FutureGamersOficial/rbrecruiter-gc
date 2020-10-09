<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
                ->subject('You have just been invited to ' . $this->teamName)
                ->view('mail.invited-to-team');
    }
}
