<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Notifications;

use App\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

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
                    ->greeting('Hi ' . $notifiable->name . ',')
                    ->from(config('notification.sender.address'), config('notification.sender.name'))
                    ->subject(config('app.name').' - application denied')
                    ->line('We\'re sorry to inform you that your application with us has been reviewed and declined.')
                    ->line('Our review team denies applications for several reasons, including poor answers, missing information, or lacking qualifications.')
                    ->line('Please review your application and try again later. You can view your account\'s eligibility status in your dashboard.')
                    ->action('Review application', url(route('showUserApp', ['application' => $this->application->id])))
                    ->salutation('The team at ' . config('app.name'));
    }

    public function toSlack($notifiable)
    {
        $notifiableName = $notifiable->name;

        return (new SlackMessage)
              ->error()
              ->content('An application has just been denied.')
              ->attachment(function ($attachment) use ($notifiableName) {
                  $attachment->title('Application denied!')
                             ->content($notifiableName.'\'s application has just been denied. They can try again in 30 days.');
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
