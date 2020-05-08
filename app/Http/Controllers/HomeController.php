<?php

namespace App\Http\Controllers;

use App\Vacancy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')
            ->with('positions', Vacancy::where('vacancyStatus', 'OPEN')->get());
    }
}
