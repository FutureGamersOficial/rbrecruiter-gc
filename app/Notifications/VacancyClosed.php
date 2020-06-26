<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Vacancy;

class VacancyClosed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $vacancy;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Vacancy $vacancy)
    {
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
                    ->from(config('notification.sender.address'), config('notification.sender.name'))
                    ->subject(config('app.name') . ' - Vacancy Closed')
                    ->line('The vacancy ' . $this->vacancy->vacancyName . ', with ' . $this->vacancy->vacancyCount . ' remaining slots, has just been closed.')
                    ->line('Please be aware that this position may be deleted/reopened any time.')
                    ->action('View positions', url(route('showPositions')))
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
