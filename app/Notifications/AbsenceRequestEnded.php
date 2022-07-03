<?php

namespace App\Notifications;

use App\Absence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbsenceRequestEnded extends Notification implements ShouldQueue
{
    use Queueable;

    public Absence $absence;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Absence $absence)
    {
        $this->absence = $absence;
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
                ->subject(config('app.name').' - absence request expired')
                ->line("Your Leave of Absence request from {$this->absence->created_at} (until {$this->absence->predicted_end}) has expired today.")
                ->line('Please note that any inactivity will be counted in our activity metrics. You may now make a new request if you still need more time.')
                ->action('Send new request', url(route('absences.create')))
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
