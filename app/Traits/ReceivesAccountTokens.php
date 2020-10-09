<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


use App\Http\Requests\UserDeleteRequest;
use App\Mail\UserAccountDeleteConfirmation;
use App\User;


trait ReceivesAccountTokens
{
    public function userDelete(UserDeleteRequest $request)
    {
        // a little verbose
        $user = User::find(Auth::user()->id);
        $tokens = $user->generateAccountTokens();

        Mail::to($user)->send(new UserAccountDeleteConfirmation($user, $tokens, $request->ip()));

        $user->delete();
        Auth::logout();

        $request->session()->flash('success', 'Please check your email to finish deleting your account.');
        return redirect()->to('/');
    }


    public function processDeleteConfirmation(Request $request, $ID, $action, $token)
    {
        // We can't rely on Laravel's route model injection, because it'll ignore soft-deleted models,
        // so we have to use a special scope to find them ourselves.
        $user = User::withTrashed()->findOrFail($ID);
        $email = $user->email;

        switch($action)
        {
            case 'confirm':

                if ($user->verifyAccountToken($token, 'deleteToken'))
                {
                    Log::info('SECURITY: User deleted account!', [

                        'confirmDeleteToken' => $token,
                        'ipAddress' => $request->ip(),
                        'email' => $user->email

                    ]);
                    
                    
                
                    $user->forceDelete();

                    $request->session()->flash('success', 'Account permanently deleted. Thank you for using our service.');
                    return redirect()->to('/');
                }

                break;
            
            case 'cancel':

                if ($user->verifyAccountToken($token, 'cancelToken'))
                {
                    $user->restore();
                    $request->session()->flash('success', 'Account deletion cancelled! You may now login.');

                    return redirect()->to(route('login'));
                }

                break;
            
            default:
            
                abort(404, 'The page you were trying to access may not exist or may be expired.');
        }

    }
}