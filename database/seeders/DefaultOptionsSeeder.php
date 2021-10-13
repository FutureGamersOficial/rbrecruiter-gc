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

namespace Database\Seeders;

use App\Facades\Options;
use Illuminate\Database\Seeder;

class DefaultOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Options::setOption('notify_new_application_email', true, 'Notify when a new application comes through', 'notifications'); // done
        Options::setOption('notify_application_comment', false, 'Notify when someone comments on an application' , 'notifications'); // done
        Options::setOption('notify_new_user', true, 'Notify when someone signs up'); // done
        Options::setOption('notify_application_status_change', true, 'Notify when an application changes status' , 'notifications'); // done
        Options::setOption('notify_applicant_approved', true, 'Notify when an applicant is approved' , 'notifications'); // done
        Options::setOption('notify_vacancystatus_change', false, 'Notify when a vacancy\'s status changes' , 'notifications'); // done

        Options::setOption('enable_slack_notifications', true, 'Enable slack notifications' , 'notifications');
        Options::setOption('enable_email_notifications', true, 'Enable e-mail notifications' , 'notifications');

        // added in 0.6.2
        Options::setOption('pw_security_policy', 'low', 'Describes the current password security policy.', 'app_security');
        Options::setOption('graceperiod', 7, '2FA Grace Period', 'app_security');
        Options::setOption('password_expiry', '0', 'Defines wether passwords must be reset after $value', 'app_security');
        Options::setOption('force2fa', false, 'Defines whether 2fa is forced upon users', 'app_security');
        Options::setOption('force2faRole', 'reviewer', 'Defines which role to force 2fa for', 'app_security');
        Options::setOption('requireGameLicense', true, 'Defines whether people need to validate their game license', 'app_security');

        Options::setOption('currentGame', 'MINECRAFT', 'Defines what game we\'re working with', 'app_integration');

    }
}
