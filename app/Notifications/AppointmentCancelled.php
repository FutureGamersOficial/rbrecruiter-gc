<?php

namespace App\Notifications;

use App\Application;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCancelled extends Notification
{
    use Queueable;

    private $application;
    private $reason;
    private $appointmentDate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $app, Carbon $appointmentDate, $reason)
    {
        $this->application = $app;
        $this->reason = $reason;
        $this->appointmentDate = $appointmentDate;
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
        // TODO: Switch to HTML & Blade.

        return (new MailMessage)
            ->greeting("Hi " . $notifiable->name . ",")
            ->from(config('notification.sender.address'), config('notification.sender.name'))
            ->subject(config('app.name').' - interview cancelled')
            ->line('The interview that was previously scheduled with you has been cancelled.')
            ->line('Date and time of the old appointment:  '.$this->appointmentDate)
            ->line('Your appointment was cancelled for the following reason: ' . $this->reason)
            ->line('A team member may contact you to reschedule within a new timeframe - you may also let us know of a date and time that suits you.')
            ->line('Your application will likely be declined if you do not reschedule an interview.')
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
