<?php

namespace App\Http\Controllers;

use App\Appeal;
use Illuminate\Http\Request;

// temp logic
/*
 * Appeal types:
 *  - Discord ban appeal (Will prompt user to login with Discord, if account is not linked)
 *  - Site ban appeal (Can be filled while logged out, requires a valid email address, won't prompt for Discord auth)
 *  - Timeout appeal (Will prompt user to login with Discord, if account is not linked)
 *
 */
class AppealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appeal  $appeal
     * @return \Illuminate\Http\Response
     */
    public function show(Appeal $appeal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appeal  $appeal
     * @return \Illuminate\Http\Response
     */
    public function edit(Appeal $appeal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appeal  $appeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appeal $appeal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appeal  $appeal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appeal $appeal)
    {
        //
    }
}
