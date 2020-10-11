@extends('adminlte::page')

@section('title', config('app.name') . ' | Team Files')

@section('content_header')
    <h1>{{config('app.name')}} / Teams / Files</h1>
@stop

@section('js')

    <x-global-errors></x-global-errors>
@stop

@section('content')

    <x-modal id="upload-dropzone" modal-label="upload-dropzone-modal" modal-title="Upload Files" include-close-button="true">

        <form class="dropzone" id="teamFile" action="{{route('uploadTeamFile')}}"></form>

        <x-slot name="modalFooter">

        </x-slot>
    </x-modal>

    <div class="row">

        <div class="col-3 offset-3">
            <img src="/img/files.svg" width="230px" height="230px" alt="Team files illustration">
        </div>

    </div>

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
                                    <td>{{ $file->size }} bytes</td>
                                    <td>{{ $file->updated_at }}</td>
                                    <td>
                                        <button rel="buttonTxtTooltip" data-toggle="tooltip" data-placement="top" title="Download" type="button" class="btn btn-success btn-sm ml-3" onclick="window.location='{{route('downloadTeamFile', ['teamFile' => $file->id])}}'"><i class="fas fa-download"></i></button>
                                        <button rel="buttonTxtTooltip" data-toggle="tooltip" data-placement="top" title="View" type="button" class="btn btn-success btn-sm ml-3"><i class="fas fa-eye"></i></button>
                                        <button rel="buttonTxtTooltip" data-toggle="tooltip" data-placement="top" title="Delete File" type="button" class="btn btn-danger btn-sm ml-3"><i class="fas fa-trash"></i></button>
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
                    <button type="button" class="btn btn-warning" onclick="$('#upload-dropzone').modal('show')"><i class="fas fa-upload"></i> Upload Files</button>
                    {{ $files->links() }}
                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
