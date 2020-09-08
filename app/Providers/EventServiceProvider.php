<?php

namespace App\Providers;

use App\Listeners\LogAuthenticationFailure;
use App\Listeners\OnUserRegistration;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
            OnUserRegistration::class
        ],
        Failed::class => [
            LogAuthenticationFailure::class
        ],
        'App\Events\ApplicationApprovedEvent' => [
            'App\Listeners\PromoteUser'
        ],
        'App\Events\ApplicationDeniedEvent' => [
            'App\Listeners\DenyUser'
        ],
        'App\Events\UserBannedEvent' => [
            'App\Listeners\OnUserBanned'
        ]
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
