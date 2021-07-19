<?php

namespace App\Http\Controllers;

// Most of these namespaces have no effect on the code, however, they're used by IDEs so they can resolve return types and for PHPDocumentor as well


use App\TeamFile;
use App\Http\Requests\UploadFileRequest;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;
// Documentation-purpose namespaces
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class TeamFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', TeamFile::class);

        if (is_null(Auth::user()->currentTeam))
        {
            $request->session()->flash('error', 'Please choose a team before viewing it\'s files.');
            return redirect()->to(route('teams.index'));
        }

        return view('dashboard.teams.team-files')
            ->with('files', TeamFile::with('team', 'uploader')->paginate(6));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UploadFileRequest $request
     * @return RedirectResponse
     */
    public function store(UploadFileRequest $request)
    {
        $this->authorize('store', TeamFile::class);

        $upload = $request->file('file');

        $file = $upload->store('uploads');
        $originalFileName = $upload->getClientOriginalName();
        $originalFileExtension = $upload->extension();
        $originalFileSize = $upload->getSize();

        $fileEntry = TeamFile::create([
            'uploaded_by' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
            'name' => $originalFileName,
            'caption' => $request->caption,
            'description' => $request->description,
            'fs_location' => $file,
            'extension' => $originalFileExtension,
            'size' => $originalFileSize
        ]);

        if ($fileEntry && !is_bool($file))
        {
            $request->session()->flash('success', 'File uploaded successfully!');
            return redirect()->back();
        }

        $request->session()->flash('error', 'There was an unknown error whilst trying to upload your file.');
        return redirect()->back();

    }


    public function download(Request $request, TeamFile $teamFile)
    {
        $this->authorize('download', TeamFile::class);

        try
        {
            return Storage::download($teamFile->fs_location, $teamFile->name);
        }
        catch (FileNotFoundException $ex)
        {
           $request->session()->flash('error', 'Sorry, but the requested file could not be found in storage. Sometimes, files may be physically deleted by admins, but not from the app\'s database.');
           return redirect()->back();

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeamFile  $teamFile
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, TeamFile $teamFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param \App\TeamFile $teamFile
     * @return RedirectResponse
     */
    public function destroy(Request $request, TeamFile $teamFile)
    {
        $this->authorize('delete', $teamFile);

        try
        {
            Storage::delete($teamFile->fs_location);
            $teamFile->delete();

            $request->session()->flash('success', __('File deleted successfully.'));
        }
        catch (\Exception $ex)
        {
            $request->session()->flash('error', __('There was an error deleting the file: :msg', ['msg' => $ex->getMessage()]));
        }

        return redirect()->back();
    }
}
