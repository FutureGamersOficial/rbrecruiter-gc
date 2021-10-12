<?php


namespace App\Services;


use App\Exceptions\FailedCaptchaException;
use App\Notifications\NewContact;
use App\User;
use Illuminate\Support\Facades\Http;

class ContactService
{

    /**
     * Sends a message to all admins.
     *
     * @throws FailedCaptchaException
     */
    public function sendMessage($ipAddress, $message, $email, $challenge)
    {
        // TODO: now: add middleware for this verification, move to invisible captcha
        $verifyrequest = Http::asForm()->post(config('recaptcha.verify.apiurl'), [
            'secret' => config('recaptcha.keys.secret'),
            'response' => $challenge,
            'remoteip' => $ipAddress,
        ]);

        $response = json_decode($verifyrequest->getBody(), true);

        if (! $response['success']) {
            throw new FailedCaptchaException('Beep beep boop... Robot? Submission failed.');
        }

        foreach (User::all() as $user) {
            if ($user->hasRole('admin')) {
                $user->notify(new NewContact(collect([
                    'message' => $message,
                    'ip' => $ipAddress,
                    'email' => $email,
                ])));
            }
        }
    }


}
