<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\User;
use App\Ban;

class UserBanned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    protected $ban;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Ban $ban)
    {
        $this->user = $user;
        $this->ban = $ban;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // slack
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from(config('notification.sender.address'), config('notification.sender.name'))
                    ->line('Hello, ')
                    ->line('Moderators have just banned user ' . $this->user->name . ' for ' . $this->ban->reason)
                    ->line('This ban will remain in effect until ' . $this->ban->bannedUntil . '.')
                    ->action('View profile', url(route('showSingleProfile', ['user' => $this->user->id])))
                    ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
