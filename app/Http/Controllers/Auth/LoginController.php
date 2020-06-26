<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as protected originalAttemptLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // We can't customise the error message, since that would imply overriding the login method, which is large.
    // Also, the user should never know that they're banned.
    public function attemptLogin(Request $request) 
    {
        $user = User::where('email', $request->email)->first();

        if ($user)
        {
            $isBanned = $user->isBanned();
            if ($isBanned)
            {
                return false;
            }
            else
            {
                return $this->originalAttemptLogin($request);
            }
        }
        
        return $this->originalAttemptLogin($request);
        
    }


}
