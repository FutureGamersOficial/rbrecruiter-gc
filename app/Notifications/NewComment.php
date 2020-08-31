<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Comment;
use App\Application;
use App\Traits\Cancellable;
use App\Facades\Options;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable, Cancellable;


    protected $application;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, Application $application)
    {
        $this->application = $application;
    }

    public function optOut($notifiable)
    {
        return Options::getOption('notify_application_comment') !== 1;
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
                    ->subject(config('app.name') . ' - New comment')
                    ->line('Someone has just posted a new comment on an application you follow.')
                    ->line('You\'re receiving this email because you\'ve voted/commented on this application.')
                    ->action('Check it out', url(route('showUserApp', ['application' => $this->application->id])))
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
