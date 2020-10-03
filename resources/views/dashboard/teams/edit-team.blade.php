@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.teams.m_teams_page'))

@section('content_header')
    <h1>{{config('app.name')}} / {{__('messages.teams.m_teams_page')}}</h1>
@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop


@section('content')

    @if($team->openJoin == false)
        <x-modal id="addUserModal" modal-label="addUserModalLabel" modal-title="Invite User" include-close-button="true">

            <form id="inviteToTeam" method="POST" action="{{ route('sendInvite', ['team' => $team->id]) }}">
                @csrf
                <div class="form-group">
                    <select class="custom-select" name="user">
                        <option disabled selected>Choose a user to invite</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ ($user->id == Auth::user()->id) ? 'disabled' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-sm text-muted"><i class="fas fa-info-circle"></i> This user will receive an email notification asking them to join your team.</span>
                </div>

            </form>

            <x-slot name="modalFooter">
                <button type="button" class="btn btn-success" onclick="$('#inviteToTeam').submit()"><i class="fas fa-paper-plane"></i> Send invite</button>
            </x-slot>

        </x-modal>
    @endif

    <div class="row">

        <div class="col text-center">
            <img src="/img/editable.svg" alt="Edit illustration" height="220px" width="220px">
        </div>

    </div>


    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">Edit Team</h4>
                </div>

                <div class="card-body">
                    
                    <form id="editTeam" method="POST" action="{{ route('teams.update', ['team' => $team->id]) }}">

                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                
                            <label for="teamName">Team name</label>
                            <input type="text" class="form-control" id="teamName" value="{{ $team->name }}" disabled>
            
                            <label for="teamDescription">Team description</label>
                            <textarea class="form-control" rows="4" name="teamDescription" id="teamDescription">{{ $team->description }}</textarea>
                            <span class="text-left text-muted text-sm"><a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet"><i class="fab fa-markdown"></i></a> Markdown supported</span>
                            
                            <div class="controlbuttons mt-3">

                                <span rel="spanTxtTooltip" data-toggle="tooltip" title="This setting controls whether people can join the team freely." data-placement="top">
                                    <input type="hidden" name="joinType" value="0"> <!-- unchecked checkbox hack (no js) -->
                                    <input value="0" type="checkbox" {{ ($team->openJoin == 1) ? 'checked' : '' }} name="joinType" id="jointype" data-toggle="toggle" data-on="Public Team" data-off="Private" data-onstyle="success" data-offstyle="danger" data-width="100">
                                </span>

                                <button onclick="$('#addUserModal').modal('show')" type="button" id="inviteUser" name="inviteUser" class="btn btn-success" {{ ($team->openJoin) ? 'disabled' : '' }}><i class="fas fa-user-plus"></i> Invite user</button>
                            </div>
            
                        </div>

                    </form>
                    
                </div>

                <div class="card-footer">
                    <button type="button" class="btn btn-success" onclick="$('#editTeam').submit()"><i class="fas fa-save"></i> Save and Close</button>
                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('teams.index') }}'"><i class="far fa-trash-alt"></i> Cancel</button>
                </div>

            </div>

        </div>


    </div>

@stop