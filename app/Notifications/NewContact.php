<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class NewContact extends Notification
{
    use Queueable;

    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Collection $message)
    {
        $this->message = $message;
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
        if ($this->message->has([
          'message',
          'ip',
          'email'
        ]))
        {
          return (new MailMessage)
                      ->line('We\'ve received a new contact form submission in the StaffManagement app center.')
                      ->line('This is what they sent: ')
                      ->line('')
                      ->line($this->message->get('message'))
                      ->line('')
                      ->line('This message was received from ' . $this->message->get('ip') . ' and submitted by ' . $this->message->get('email') . '.')
                      ->action('Sign in', url(route('login')))
                      ->line('Thank you!');
        }

        throw new \InvalidArgumentException("Invalid arguments supplied to NewContact!");
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
