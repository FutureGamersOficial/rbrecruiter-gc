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

use App\Facades\Options;
use App\Traits\Cancellable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ApplicationMoved extends Notification implements ShouldQueue
{
    use Queueable, Cancellable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function channels()
    {
        Log::debug('Application moved notification: channels chosen', [
            'channels' => $this->chooseChannelsViaOptions()
        ]);
        return $this->chooseChannelsViaOptions();
    }

    public function optOut($notifiable)
    {
        Log::debug('Application moved notification: opt out verified', [
            'opt-out' => Options::getOption('notify_application_status_change') != 1
        ]);

        return Options::getOption('notify_application_status_change') != 1;
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
                    ->subject(config('app.name').' - application updated')
                    ->line('Your application has been moved to the next step.')
                    ->line('This means our team has reviewed it and an interview will be scheduled soon.')
                    ->action('Sign in', url(route('login')))
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
