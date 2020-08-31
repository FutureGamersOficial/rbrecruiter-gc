<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

use App\Vacancy;
use App\Facades\Options;
use App\Traits\Cancellable;

class VacancyClosed extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels, Cancellable;

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

    public function optOut($notifiable)
    {
        return Options::getOption('notify_vacancystatus_change') !== 1;
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
