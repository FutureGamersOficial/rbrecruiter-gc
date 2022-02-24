<?php

namespace App\Notifications;

use App\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationConfirmed extends Notification
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
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
            ->subject(config('app.name') . ' - application confirmed')
            ->line('We\'re writing you to let you know that your recent application with us has been received, and will be processed in 24/48 hours.')
            ->line('You will receive regular notifications about your application\'s status.')
            ->action('View active applications', url(route('showUserApps')))
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
