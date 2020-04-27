<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;

class ContactController extends Controller
{

    public function create(Request $request)
    {
        // TODO: use service provider instead
        $client = new GuzzleHttp\Client();

        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $msg = $request->msg;

        $challenge = $request->input('captcha');

        $verifyrequest = $client->request('POST', config('recaptcha.verify.apiurl'), [
            'form_params' => [
                'secret' => config('recaptcha.keys.secret'),
                'response' => $challenge,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ]
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
