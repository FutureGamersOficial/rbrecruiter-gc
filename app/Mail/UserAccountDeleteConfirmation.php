<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\User;

class UserAccountDeleteConfirmation extends Mailable
{
    use Queueable, SerializesModels;



    public $deleteToken;


    public $cancelToken;


    public $originalIP;


    public $name;


    public $userID;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, array $tokens, string $originalIP)
    {
        $this->deleteToken = $tokens['delete'];
        $this->cancelToken = $tokens['cancel'];

        $this->originalIP = $originalIP;
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
        return $this->view('mail.deleted-account');
    }
}
