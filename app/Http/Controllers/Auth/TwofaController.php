<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\AuthenticatesTwoFactor;

class TwofaController extends Controller
{
  use AuthenticatesTwoFactor;


  protected $redirectTo = '/dashboard';

}
