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
use App\Facades\Options;
use App\Traits\Cancellable;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ApplicationApproved extends Notification implements ShouldQueue
{
    use Queueable, Cancellable;


    /**
     * @var Application The application we're notifying about
     */
    public Application $application;


    /**
     * @var User The candidate
     */
    public User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function channels()
    {
        return $this->chooseChannelsViaOptions();
    }

    public function optOut($notifiable)
    {
        return Options::getOption('notify_applicant_approved') != 1;
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
                    ->subject(config('app.name').' - application approved')
                    ->line('Congratulations! Your most recent application has been approved by the reviewing team.')
                    ->line('You have just received the Reviewer role, which allows you to view and vote on other applications.')
                    ->line('You should have received more information about your onboarding process by now.')
                    ->line('Good luck and welcome aboard!')
                    ->action('Sign in', url(route('login')))
                    ->salutation('The team at ' . config('app.name'));
    }

    public function toSlack($notifiable)
    {
        $url = route('showSingleProfile', ['user' => $notifiable->id]);
        $roles = implode(', ', $notifiable->roles->pluck('name')->all());

        return (new SlackMessage)
              ->success()
              ->content('A user has been approved on the team. Welcome aboard!')
              ->attachment(function ($attachment) use ($notifiable, $url, $roles) {
                  $attachment->title('New staff member')
                              ->fields([
                                  'Name' => $notifiable->name,
                                  'Email' => $notifiable->email,
                                  'Roles' => $roles,
                              ])
                              ->action('View profile', $url);
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
