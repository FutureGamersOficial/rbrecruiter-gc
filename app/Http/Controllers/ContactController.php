<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{

    public function create(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $msg = $request->msg;

        $challenge = $request->input('captcha');

        $verifyrequest = Http::asForm()->post(config('recaptcha.verify.apiurl'), [
            'secret' => config('recaptcha.keys.secret'),
            'response' => $challenge,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ]);

        $response = json_decode($verifyrequest->getBody(), true);

        if (!$response['success'])
        {
            $request->session()->flash('error', 'Beep beep boop... Robot? Submission failed.');
            return redirect()->back();
        }

        // TODO: Send mail

        $request->session()->flash('success', 'Message sent successfully! We usually respond within 48 hours.');
        return redirect()->back();
    }
}
