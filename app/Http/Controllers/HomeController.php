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

        $positions = Vacancy::where('vacancyStatus', 'OPEN')
                            ->where('vacancyCount', '<>', 0)
                            ->get();

      
        return view('home')
            ->with('positions', $positions);
    }
}
