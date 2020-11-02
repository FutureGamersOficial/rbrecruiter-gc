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

namespace App\Traits;

use App\Facades\Options;

trait Cancellable
{
    public function chooseChannelsViaOptions()
    {
        $channels = [];

        if (Options::getOption('enable_slack_notifications') == 1) {
            array_push($channels, 'slack');
        } elseif (Options::getOption('enable_email_notifications') == 1) {
            array_push($channels, 'email');
        }

        return $channels;
    }

    public function channels()
    {
        return ['mail'];
    }

    public function via($notifiable)
    {
        if ($this->optOut($notifiable)) {
            return [];
        }

        return $this->channels();
    }

    public function optOut($notifiable)
    {
        return false;
    }
}
