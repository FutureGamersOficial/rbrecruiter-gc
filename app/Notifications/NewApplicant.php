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
use App\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewApplicant extends Notification implements ShouldQueue
{
    use Queueable, Cancellable;

    protected $application;

    protected $vacancy;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $application, Vacancy $vacancy)
    {
        $this->application = $application;
        $this->vacancy = $vacancy;
    }

    public function channels()
    {
        if (Options::getOption('enable_slack_notifications') == 1) {
            return ['slack'];
        }

        return [];
    }

    public function optOut($notifiable)
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
                    ->subject(config('app.name').' - New application')
                    ->line('Someone has just applied for a position. Check it out!')
                    ->line('You are receiving this because you\'re a staff member at '.config('app.name').'.')
                    ->action('View Application', url(route('showUserApp', ['application' => $this->application->id])))
                    ->salutation('The team at ' . config('app.name'));
    }

    public function toSlack($notifiable)
    {
        $vacancyDetails = [];
        $vacancyDetails['name'] = $this->vacancy->vacancyName;
        $vacancyDetails['slots'] = $this->vacancy->vacancyCount;

        $url = route('showUserApp', ['application' => $this->application->id]);
        $applicant = $this->application->user->name;

        return (new SlackMessage)
            ->success()
            ->content('Notice: New application coming through. Please review as soon as possible.')
            ->attachment(function ($attachment) use ($vacancyDetails, $url, $applicant) {
                $attachment->title('Application details')
                           ->fields([
                               'Applied for' => $vacancyDetails['name'],
                               'Available positions' => $vacancyDetails['slots'],
                               'Applicant' => $applicant,
                           ])
                           ->action('Review application', $url);
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
