<?php

namespace App\Policies;

use App\Application;
use Illuminate\Auth\Access\Response;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Application $application)
    {
       if ($user->is($application->user) && $user->can('applications.view.own') || $user->can('applications.view.all'))
       {
           return Response::allow();
       }

       return Response::deny('You are not authorised to view this application');
    }
}
