<?php


namespace App\Services;


use App\Exceptions\FileUploadException;
use App\TeamFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class TeamFileService
{

    public function addFile(UploadedFile $upload, $uploader, $team, $caption, $description) {

        $file = $upload->store('uploads');
        $originalFileName = $upload->getClientOriginalName();
        $originalFileExtension = $upload->extension();
        $originalFileSize = $upload->getSize();

        $fileEntry = TeamFile::create([
            'uploaded_by' => $uploader,
            'team_id' => $team,
            'name' => $originalFileName,
            'caption' => $caption,
            'description' => $description,
            'fs_location' => $file,
            'extension' => $originalFileExtension,
            'size' => $originalFileSize
        ]);

        if ($fileEntry && !is_bool($file))
        {
           return $fileEntry;
        }

        throw new FileUploadException("There was an unknown error whilst trying to upload your file.");

    }

}
