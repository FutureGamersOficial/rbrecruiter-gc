<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use App\Application;

class ApplicationDenied extends Notification implements ShouldQueue
{
    use Queueable;


    public $application;

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
        return ['mail', 'slack'];
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
                    ->subject(config('app.name') . ' - ' . $this->application->response->vacancy->vacancyName . ' application denied')
                    ->line('Your most recent application has been denied.')
                    ->line('Our review team denies applications for several reasons, including poor answers.')
                    ->line('Please review your application and try again in 30 days.')
                    ->action('Review application', url(route('showUserApp', ['id' => $this->application->id])))
                    ->line('Better luck next time!');
    }


    public function toSlack($notifiable)
    {
      $notifiableName = $notifiable->name;

      return (new SlackMessage)
              ->error()
              ->content('An application has just been denied.')
              ->attachment(function($attachment) use ($notifiableName){
                  $attachment->title('Application denied!')
                             ->content($notifiableName . '\'s application has just been denied. They can try again in 30 days.');
              });

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
