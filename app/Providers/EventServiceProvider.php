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

namespace App\Providers;

use App\Listeners\LogAuthenticationFailure;
use App\Listeners\LogAuthenticationSuccess;
use App\Listeners\OnUserRegistration;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Discord\DiscordExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            OnUserRegistration::class,
        ],
        Failed::class => [
            LogAuthenticationFailure::class,
        ],
        Login::class => [
            LogAuthenticationSuccess::class,
        ],
        SocialiteWasCalled::class => [
            // ... other providers
            DiscordExtendSocialite::class.'@handle',
        ],
        'App\Events\ApplicationApprovedEvent' => [
            'App\Listeners\PromoteUser',
        ],
        'App\Events\ApplicationDeniedEvent' => [
            'App\Listeners\DenyUser',
        ],
        'App\Events\UserBannedEvent' => [
            'App\Listeners\OnUserBanned',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
