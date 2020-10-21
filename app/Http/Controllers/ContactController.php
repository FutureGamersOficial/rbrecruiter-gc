<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use App\Notifications\NewContact;
use Illuminate\Support\Facades\Http;

use App\User;

class ContactController extends Controller
{

    protected $users;


    public function __construct(User $users)
    {
        $this->users = $users;
    }


    public function create(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $msg = $request->msg;

        $challenge = $request->input('captcha');

        // TODO: now: add middleware for this verification, move to invisible captcha
        $verifyrequest = Http::asForm()->post(config('recaptcha.verify.apiurl'), [
            'secret' => config('recaptcha.keys.secret'),
            'response' => $challenge,
            'remoteip' => $request->ip()
        ]);


        $response = json_decode($verifyrequest->getBody(), true);

        if (!$response['success'])
        {
            $request->session()->flash('error', 'Beep beep boop... Robot? Submission failed.');
            return redirect()->back();
        }


        foreach(User::all() as $user)
        {
          if ($user->hasRole('admin'))
          {
            $user->notify(new NewContact(collect([
              'message' => $msg,
              'ip' => $request->ip(),
              'email' => $email
            ])));
          }
        }

        $request->session()->flash('success', 'Message sent successfully! We usually respond within 48 hours.');
        return redirect()->back();
    }
}
