<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{

    public function index()
    {
        return view('dashboard.administration.forms');
    }

    public function saveForm(Request $request)
    {
        dd($request->all());
    }

}
