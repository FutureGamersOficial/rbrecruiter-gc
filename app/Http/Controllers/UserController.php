<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function showStaffMembers()
    {
        return view('dashboard.administration.staff-members');
    }

    public function showPlayers()
    {

    }
}
