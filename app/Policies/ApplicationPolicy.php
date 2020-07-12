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

    public function viewAny(User $user)
    {
      if ($user->can('applications.view.all'))
      {
        return Response::allow();
      }

      return Response::deny('Forbidden');
    }

    public function view(User $user, Application $application)
    {
       if ($user->is($application->user) && $user->can('applications.view.own') || $user->can('applications.view.all'))
       {
           return Response::allow();
       }

       return Response::deny('You are not authorised to view this application');
    }

    public function update(User $user)
    {
        return $user->hasAnyRole('admin', 'hiringManager');
    }

    public function delete(User $user, Application $application)
    {

      return $user->hasRole('admin');

    }
}
