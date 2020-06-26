<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use App\Application;

class ApplicationApproved extends Notification implements ShouldQueue
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
                    ->subject(config('app.name') . ' - ' . $this->application->response->vacancy->vacancyName . ' application approved')
                    ->line('<br />')
                    ->line('Congratulations! Our Staff team has reviewed your application today, and your application has been approved.')
                    ->line('You have just received the Reviewer role, which allows you to view and vote on other applications.')
                    ->line('Your in-game rank should be updated network-wide in the next few minutes, allowing you to perform staff duties.')
                    ->line('Please join a voice channel when possible for your training meeting, if this has been mentioned by your interviewer.')
                    ->line('<br />')
                    ->line('Good luck and welcome aboard!')
                    ->action('Sign in', url(route('login')))
                    ->line('Thank you!');
    }

    public function toSlack($notifiable)
    {

        $url = route('showSingleProfile', ['user' => $notifiable->id]);
        $roles = implode(', ', $notifiable->roles->pluck('name')->all());

        return (new SlackMessage)
              ->success()
              ->content('A user has been approved on the team. Welcome aboard!')
              ->attachment(function($attachment) use ($notifiable, $url, $roles){
                  $attachment->title('New staff member')
                              ->fields([
                                  'Name' => $notifiable->name,
                                  'Email' => $notifiable->email,
                                  'Roles' => $roles
                              ])
                              ->action('View profile', $url);
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
