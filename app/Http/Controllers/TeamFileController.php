<?php

namespace App\Http\Controllers;

use App\TeamFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class TeamFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null(Auth::user()->currentTeam))
        {
            $request->session()->flash('error', 'Please choose a team before viewing it\'s files.');
            return redirect()->to(route('teams.index'));
        }

        return view('dashboard.teams.team-files')
            ->with('files', TeamFile::with('team', 'uploader')->paginate(20));
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


    public function download(Request $request, TeamFile $teamFile)
    {
        try
        {
            return Storage::download('uploads/' . $teamFile->name);
        }
        catch (FileNotFoundException $ex)
        {
           $request->session()->flash('error', 'Sorry, but the requested file could not be found in storage. Sometimes, files may be physically deleted by admins, but not from the app\'s database.');
           return redirect()->back();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeamFile  $teamFile
     * @return \Illuminate\Http\Response
     */
    public function show(TeamFile $teamFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeamFile  $teamFile
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamFile $teamFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeamFile  $teamFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamFile $teamFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeamFile  $teamFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamFile $teamFile)
    {
        //
    }
}
