<?php

namespace App\Http\Controllers;

// Most of these namespaces have no effect on the code, however, they're used by IDEs so they can resolve return types and for PHPDocumentor as well


use App\Exceptions\FileUploadException;
use App\Services\TeamFileService;
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
    private $fileService;

    public function __construct(TeamFileService $fileService) {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
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

        try {
            $caption = $request->caption;
            $description = $request->description;

            $this->fileService->addFile($request->file('file'), Auth::user()->id, Auth::user()->currentTeam->id, $caption, $description);

            return redirect()
                ->back()
                ->with('success', __('File uploaded successfully.'));

        } catch (FileUploadException $uploadException) {

            return redirect()
                ->back()
                ->with('error', $uploadException->getMessage());

        }

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
