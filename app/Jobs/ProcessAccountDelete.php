<?php

namespace App\Jobs;

use App\Notifications\AccountDeleted;
use App\Notifications\UserDeletedAccount;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ProcessAccountDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user to work with
     *
     * @var User
     */
    protected User $user;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::alert('[Worker] Processing account deletion request', [
            'email' => $this->user->email
        ]);

        $email = $this->user->email;
        $name = $this->user->name;

        if ($this->user->delete()) {
            Notification::route('mail', [
                $email => $name
            ])->notify(new AccountDeleted($name));

            // Notify admins
            Notification::send(User::role('admin')->get(), new UserDeletedAccount($email));
        }
    }
}
