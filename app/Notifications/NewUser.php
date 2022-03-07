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
use App\Facades\UUID;
use App\Traits\Cancellable;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewUser extends Notification implements ShouldQueue
{
    use Queueable, Cancellable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function channels()
    {
        return $this->chooseChannelsViaOptions();
    }

    public function optOut()
    {
        return Options::getOption('notify_new_user') != 1;
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
                    ->subject(config('app.name').' - New user')
                    ->line($this->user->name.' has created a new account.')
                    ->line('This request came from the IP address ' . $this->user->originalIP . '.')
                    ->line('You are receiving this email because you\'re a site admin, and the app is configured to send new user notifications.')
                    ->action('View user', url(route('showSingleProfile', ['user' => $this->user->id])))
                    ->salutation('The team at ' . config('app.name'));
    }

    public function toSlack($notifiable)
    {
        $user = [];

        $user['name'] = $this->user->name;
        $user['email'] = $this->user->email;
        $user['username'] = UUID::toUsername($this->user->uuid);

        $date = \Carbon\Carbon::parse($this->user->created_at);
        $user['created_at'] = $date->englishMonth.' '.$date->day.' '.$date->year;

        return (new SlackMessage)
                ->success()
                ->content('A new user has signed up!')
                ->attachment(function ($attachment) use ($user) {
                    $attachment->title('User details')
                               ->fields([
                                   'Email address' => $user['email'],
                                   'Name' => $user['name'],
                                   'Minecraft Username' => $user['username'],
                                   'Registration date' => $user['created_at'],
                               ]);
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
