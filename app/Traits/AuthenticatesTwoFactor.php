<?php

namespace App\Traits;

use Google2FA;
use App\Http\Requests\Add2FASecretRequest;
use Illuminate\Support\Facades\Log;


trait AuthenticatesTwoFactor
{

    public function verify2FA(Add2FASecretRequest $request)
    {
        $isValid = Google2FA::verifyKey($request->user()->twofa_secret, $request->otp);

        if ($isValid)
        {
          Google2FA::login();

          Log::info('SECURITY (postauth): One-time password verification succeeded', [
            'initiator' => $request->user()->email,
            'ip' => $request->ip()
          ]);

          return redirect()->to($this->redirectTo);
        }
        else
        {
          Log::warning('SECURITY (preauth): One-time password verification failed', [
            'initiator' => $request->user()->email,
            'ip' => $request->ip()
          ]);

          $request->session()->flash('error', 'Your one time password is invalid.');
          return redirect()->back();
        }
    }

}
