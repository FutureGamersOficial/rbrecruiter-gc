<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class DiscordController extends Controller
{

    public function redirect() {

        return Socialite::driver('discord')->redirect();

    }

    public function callback() {
        //
    }


}
