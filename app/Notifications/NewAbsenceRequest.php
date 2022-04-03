<?php

namespace App\Notifications;

use App\Absence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAbsenceRequest extends Notification implements ShouldQueue
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
                ->subject(config('app.name').' - new absence request pending review')
                ->line("A new absence request has just been submitted, scheduled to end {$this->absence->predicted_end}. Please review this request and take the appropriate action(s). The requester will be notified of your decision by email.")
                ->line("You are receiving this email because you're a site admin.")
                ->action('Review request', url(route('absences.show', ['absence' => $this->absence->id])))
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
