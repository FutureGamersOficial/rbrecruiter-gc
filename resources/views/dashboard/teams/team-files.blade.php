@extends('adminlte::page')

@section('title', config('app.name') . ' | Team Files')

@section('content_header')
    <h1>{{config('app.name')}} / Teams / Files</h1>
@stop

@section('js')

    <x-global-errors></x-global-errors>
@stop

@section('content')

    @if(!$demoActive)
        <x-modal id="upload-dropzone" modal-label="upload-dropzone-modal" modal-title="Upload Files" include-close-button="true">

            <form action="{{route('uploadTeamFile')}}" enctype="multipart/form-data" method="POST" id="newFile">
                @csrf
                <div class="form-group">

                    <label for="caption">Caption</label>
                    <input id="caption" type="text" class="form-control" name="caption" required>

                    <label for="description">File description (optional)</label>
                    <textarea rows="5" name="description" id="description" class="form-control"></textarea>

                </div>


                <label class="btn btn-primary" for="file-selector">
                    <input id="file-selector" name="file" type="file" style="display:none"
                           onchange="$('#upload-file-info').html(this.files[0].name)">
                    Choose File (max {{ini_get('post_max_size')}})
                </label>
                <span class='label label-info' id="upload-file-info"></span>

            </form>

            <x-slot name="modalFooter">
                <button onclick="$('#newFile').submit()" type="button" class="btn btn-warning" rel="buttonTxtTooltip" title="Upload chosen file" data-placement="top"><i class="fas fa-upload"></i></button>
            </x-slot>
        </x-modal>
    @endif

    <div class="row">

        <div class="col-3 offset-4">
            <img src="/img/files.svg" width="230px" height="230px" alt="Team files illustration">
        </div>

    </div>

    @if($demoActive)
        <div class="row">
            <div class="col">
                <div class="alert alert-warning">
                    <p class="text-bold"><i class="fa fa-info-circle"></i> Warning</p>
                    <p>Since many users may use the app at any given time, file uploads are disabled whilst demo mode is on.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="row">

        <div class="col">

            <div class="card bg-gray-dark">

                <div class="card-header bg-indigo">
                    <div class="card-title"><h4 class="text-bold">Team Files <span class="badge badge-warning"><i class="fas fa-check-circle"></i> {{ (Auth::user()->currentTeam) ? Auth::user()->currentTeam->name : '(No team)' }}</span></h4></div>

                </div>

                <div class="card-body">

                    @if(!$files->isEmpty())

                        <table class="table table-active table-borderless" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>File name</th>
                                <th>Caption</th>
                                <th>Size</th>
                                <th>Last updated</th>
                                <th>Actions</th>
                            </tr>

                            </thead>

                            <tbody>

                            @foreach($files as $file)

                                <tr>
                                    <td>{{$file->id}}</td>
                                    <td>{{ Str::of($file->name)->limit(10, '(..).' . $file->extension) }}</td>
                                    <td>{{ Str::of($file->caption)->limit(10) }}</td>
                                    <td>{{ $file->size }}</td>
                                    <td>{{ $file->updated_at }}</td>
                                    <td>
                                        <button rel="buttonTxtTooltip" data-toggle="tooltip" data-placement="top" title="Download" type="button" class="btn btn-success btn-sm ml-2" onclick="window.location='{{route('downloadTeamFile', ['teamFile' => $file->id])}}'"><i class="fas fa-download"></i></button>
                                        <form style="white-space: nowrap; display: inline-block" action="{{route('deleteTeamFile', ['teamFile' => $file->id])}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" rel="buttonTxtTooltip" data-toggle="tooltip" data-placement="top" title="Deleting a file is irreversible!" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="alert alert-warning">

                            <span class="text-bold"><i class="fas fa-exclamation-triangle"></i> There are currently no team files. Try uploading some to get started.</span>

                        </div>

                    @endif

                </div>

                <div class="card-footer text-center">
                    <button {{ ($demoActive) ? 'disabled' : ''  }} type="button" class="btn btn-warning ml-3" onclick="$('#upload-dropzone').modal('show')"><i class="fas fa-upload"></i> Upload Files</button>
                    <button type="button" class="btn btn-success ml-3" onclick="window.location.href='{{route('teams.index')}}'"><i class="fas fa-arrow-circle-left"></i> Back</button>
                    {{ $files->links() }}
                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
