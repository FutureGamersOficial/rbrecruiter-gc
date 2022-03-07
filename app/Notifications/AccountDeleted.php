<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountDeleted extends Notification implements ShouldQueue
{
    use Queueable;

    public string $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
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
        // Adjust to notify external user
        return (new MailMessage)
                ->greeting('Hi ' . $this->name . ',')
                ->from(config('notification.sender.address'), config('notification.sender.name'))
                ->subject(config('app.name').' - account deleted permanently')
                ->line('Thank you for confirming your account deletion request. We\'re sorry to see you go!')
                ->line('Unless you sign up again, this is the last email you\'ll be receiving from us.')
                ->line('Please let us know if there\'s any feedback you\'d like to share. You can use the feedback widget located on the left-hand side of our website, or the chat widget located on the lower right corner.')
                ->line('See you around!')
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
