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
            ->from(config('notification.sender.address'), config('notification.sender.name'))
            ->subject(config('app.name').' - Interview Cancelled')
            ->greeting("Hi " . explode(' ', $this->application->user->name, 2)[0] . ",")
            ->line('The interview that was previously scheduled with you has been cancelled by a staff member.')
            ->line('Date & time of the old appointment:  '.$this->appointmentDate)
            ->line('Your appointment was cancelled for the following reason: ' . $this->reason)
            ->line('A staff member may contact you to reschedule within a new timeframe - you may also let us know of a date and time that suits you.')
            ->line('Your application will be automatically rejected within 7 days if an interview is not scheduled.')
            ->action('View ongoing applications', url(route('showUserApps')))
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
