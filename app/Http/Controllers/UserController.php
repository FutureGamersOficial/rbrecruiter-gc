<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\FlushSessionsRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\SearchPlayerRequest;
use App\Http\Requests\UpdateUserRequest;

use App\User;
use App\Ban;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Facades\UUID;
use App\Notifications\EmailChanged;
use App\Notifications\ChangedPassword;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    public function showStaffMembers()
    {
        $this->authorize('viewStaff', User::class);

        $staffRoles = [
            'reviewer',
            'hiringManager',
            'admin'
        ]; // TODO: Un-hardcode this, move to config/roles.php
        $users = User::with('roles')->get();
        $staffMembers = collect([]);

        foreach($users as $user)
        {
            if (empty($user->roles))
            {
                Log::debug($user->role->name);
                Log::debug('Staff list: User without role detected; Ignoring');
                continue;
            }

            foreach($user->roles as $role)
            {
                if (in_array($role->name, $staffRoles))
                {
                    $staffMembers->push($user);
                    continue 2; // Skip directly to the next user instead of comparing more roles for the current user
                }
            }
        }

        return view('dashboard.administration.staff-members')
            ->with([
                'users' => $staffMembers
            ]);
    }

    public function showPlayers()
    {
        $this->authorize('viewPlayers', User::class);

        $users = User::with('roles')->get();
        $players = collect([]);

        foreach($users as $user)
        {
            // TODO: Might be problematic if we don't check if the role is user
            if (count($user->roles) == 1)
            {
                $players->push($user);
            }
        }

        return view('dashboard.administration.players')
            ->with([
                'users' => $players,
                'bannedUserCount' => Ban::all()->count()
            ]);
    }


    public function showPlayersLike(SearchPlayerRequest $request)
    {
        $this->authorize('viewPlayers', User::class);

        $searchTerm = $request->searchTerm;
        $matchingUsers = User::query()
            ->where('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
            ->get();

        if (!$matchingUsers->isEmpty())
        {   $request->session()->flash('success', 'There were ' . $matchingUsers->count() . ' user(s) matching your search.');

            return view('dashboard.administration.players')
            ->with([
                'users' => $matchingUsers,
                'bannedUserCount' => Ban::all()->count()
            ]);
        }
        else
        {
            $request->session()->flash('error', 'Your search term did not return any results.');
            return redirect(route('registeredPlayerList'));
        }
    }

    public function showAccount()
    {
        return view('dashboard.user.profile.useraccount')
            ->with('ip', request()->ip());
    }


    public function flushSessions(FlushSessionsRequest $request)
    {
        // TODO: Move all log calls to a listener, which binds to an event fired by each significant event, such as this one
        // This will allow for other actions to be performed on certain events (like login failed event)

        Auth::logoutOtherDevices($request->currentPasswordFlush);
        Log::notice('User ' . Auth::user()->name . ' has logged out other devices in their account',
        [
            'originIPAddress' => $request->ip(),
            'userID' => Auth::user()->id,
            'timestamp' => now()
        ]);

        $request->session()->flash('success', 'Successfully logged out other devices. Remember to change your password if you think you\'ve been compromised.');
        return redirect()->back();
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);

        if (!is_null($user))
        {
            $user->password = Hash::make($request->newPassword);
            $user->save();

            Log::info('User ' . $user->name . ' has changed their password', [
                'originIPAddress' => $request->ip(),
                'userID' => $user->id,
                'timestamp' => now()
            ]);
            $user->notify(new ChangedPassword());

            Auth::logout();
            return redirect()->back();
        }

    }

    public function changeEmail(ChangeEmailRequest $request)
    {
        $user = User::find(Auth::user()->id);

        if (!is_null($user))
        {
            $user->email = $request->newEmail;
            $user->save();

            Log::notice('User ' . $user->name . ' has just changed their contact email address', [
                'originIPAddress' => $request->ip(),
                'userID' => $user->id,
                'timestamp' => now()
            ]);
            $user->notify(new EmailChanged());

            $request->session()->flash('success', 'Your email address has been changed!');
        }
        else
        {
            $request->session()->flash('error', 'There has been an error whilst trying to update your account. Please contact administrators.');
        }

        return redirect()->back();

    }



    public function delete(DeleteUserRequest $request, User $user)
    {
        if ($request->confirmPrompt == 'DELETE ACCOUNT')
        {
            $user->delete();
            $request->session()->flash('success','User deleted successfully. PII has been erased.');
        }
        else
        {
            $request->session()->flash('error', 'Wrong confirmation text! Try again.');
        }


        return redirect()->route('registeredPlayerList');
    }

    public function update(UpdateUserRequest $request, User $user)
    {

      // Mass update would not be possible here without extra code, making route model binding useless
      $user->email = $request->email;
      $user->name = $request->name;
      $user->uuid = $request->uuid;

      $existingRoles = Role::all()
        ->pluck('name')
        ->all();

      $roleDiff = array_diff($existingRoles, $request->roles);

      // Adds roles that were selected. Removes roles that aren't selected if the user has them.
      foreach($roleDiff as $deselectedRole)
      {
        if ($user->hasRole($deselectedRole) && $deselectedRole !== 'user')
        {
          $user->removeRole($deselectedRole);
        }
      }

      foreach($request->roles as $role)
      {
        if (!$user->hasRole($role))
        {
          $user->assignRole($role);
        }

      }

      $user->save();
      $request->session()->flash('success', 'User updated successfully!');

      return redirect()->back();

    }

    public function terminate(Request $request, User $user)
    {
        $this->authorize('terminate', User::class);

        if (!$user->isStaffMember() || $user->is(Auth::user()))
        {
            $request->session()->flash('error', 'You cannot terminate this user.');
            return redirect()->back();
        }

        foreach ($user->roles as $role)
        {
          if ($role->name == 'user')
          {
            continue;
          }

          $user->removeRole($role->name);
        }

        Log::info('User ' . $user->name . ' has just been demoted.');
        $request->session()->flash('success', 'User terminated successfully.');

        //TODO: Dispatch event
        return redirect()->back();
    }
}
