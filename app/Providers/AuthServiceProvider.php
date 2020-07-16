<?php

namespace App\Providers;

use App\Policies\ProfilePolicy;
use App\Policies\VacancyPolicy;
use App\Policies\UserPolicy;
use App\Policies\BanPolicy;
use App\Policies\FormPolicy;
use App\Policies\VotePolicy;
use App\Policies\ApplicationPolicy;
use App\Policies\AppointmentPolicy;

use App\User;
use App\Form;
use App\Vote;
use App\Vacancy;
use App\Application;
use App\Appointment;
use App\Ban;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Application::class => ApplicationPolicy::class,
        Profile::class => ProfilePolicy::class,
        User::class => UserPolicy::class,
        Vacancy::class => VacancyPolicy::class,
        //Form::class => FormPolicy::class
        'App\Form' => 'App\Policies\FormPolicy',
        Vote::class => VotePolicy::class,
        Ban::class => BanPolicy::class,
        Appointment::class => AppointmentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
