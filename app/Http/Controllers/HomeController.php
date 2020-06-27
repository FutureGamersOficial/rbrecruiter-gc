<?php

namespace App\Http\Controllers;

use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // TODO: Relationships for Applications, Users and Responses
        // Also prevent apps if user already has one in the space of 30d
        // Display apps in the relevant menus
        
        $positions = DB::table('vacancies')
                        ->where('vacancyStatus', 'OPEN')
                        ->where('vacancyCount', '!=', 0)
                        ->get();

        return view('home')
            ->with('positions', $positions);
    }
}
