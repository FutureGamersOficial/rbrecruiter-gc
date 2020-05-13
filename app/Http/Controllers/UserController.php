<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\FlushSessionsRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function showStaffMembers()
    {
        return view('dashboard.administration.staff-members');
    }

    public function showPlayers()
    {
        return view('dashboard.administration.players');
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
            Auth::logout();

            // After logout, the user gets caught by the auth filter, and it automatically redirects back to the previous page
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

            $request->session()->flash('success', 'Your email address has been changed!');
        }
        else
        {
            $request->session()->flash('error', 'There has been an error whilst trying to update your account. Please contact administrators.');
        }

        return redirect()->back();

    }
}
