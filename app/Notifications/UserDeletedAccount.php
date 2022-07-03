<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDeletedAccount extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string The email belonging to the user who wiped their acct.
     */
    public string $deletedEmail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($deletedEmail)
    {
        $this->deletedEmail = $deletedEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->greeting('Hi ' . $notifiable->name . ',')
            ->from(config('notification.sender.address'), config('notification.sender.name'))
            ->subject(config('app.name').' - someone deleted their account')
            ->line("The user {$this->deletedEmail} has just deleted their account. You may wish to review the situation.")
            ->line('You are receiving this email because you\'re a site admin.')
            ->action('View current users', url(route('registeredPlayerList')))
            ->salutation('The team at ' . config('app.name'));
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
