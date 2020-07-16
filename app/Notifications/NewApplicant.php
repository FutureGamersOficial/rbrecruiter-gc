<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use App\Application;
use App\Vacancy;

class NewApplicant extends Notification implements ShouldQueue
{
    use Queueable;


    protected $application;


    protected $vacancy;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $application, Vacancy $vacancy)
    {
        $this->application = $application;
        $this->vacancy = $vacancy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
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
                    ->subject(config('app.name') . ' - New application')
                    ->line('Someone has just applied for a position. Check it out!')
                    ->line('You are receiving this because you\'re a staff member at ' . config('app.name') . '.')
                    ->action('View Application', url(route('showUserApp', ['application' => $this->application->id])))
                    ->line('Thank you!');
    }


    public function toSlack($notifiable)
    {

        $vacancyDetails = [];
        $vacancyDetails['name'] = $this->vacancy->vacancyName;
        $vacancyDetails['slots'] = $this->vacancy->vacancyCount;

        $url = route('showUserApp', ['application' => $this->application->id]);
        $applicant = $this->application->user->name;

        return (new SlackMessage)
            ->success()
            ->content('Notice: New application coming through. Please review as soon as possible.')
            ->attachment(function($attachment) use ($vacancyDetails, $url, $applicant){
                $attachment->title('Application details')
                           ->fields([
                             'Applied for' => $vacancyDetails['name'],
                             'Avaiable positions' => $vacancyDetails['slots'],
                             'Applicant' => $applicant
                           ])
                           ->action('Review application', $url);
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
