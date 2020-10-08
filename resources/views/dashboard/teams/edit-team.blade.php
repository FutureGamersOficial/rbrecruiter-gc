@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.teams.m_teams_page'))

@section('content_header')
    <h1>{{config('app.name')}} / {{__('messages.teams.m_teams_page')}}</h1>
@stop

@section('js')

    <x-global-errors></x-global-errors>
    <script src="/js/team-editor.js"></script>

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

    <x-modal id="userlist_modal" modal-label="UserListModalLabel" modal-title="Team Members and Invites" include-close-button="true">

        <p><i class="fas fa-info-circle"></i> Team members and pending invites will appear here.</p>

        @if (!$team->users->isEmpty())
            <table class="table table-borderless">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($team->users as $teammate)
                        
                        <tr>
                            <td>{{ $teammate->id }}</td>
                            <td><a target="_blank" href="{{ route('showSingleProfile', ['user' => $teammate->id]) }}">{{ $teammate->name }}</a></td>
                            <td>
                                @foreach ($teammate->roles as $teammate_role)
                                    
                                    <span class="badge badge-secondary">{{ $teammate_role->name }}</span>

                                @endforeach
                            </td>
                            <td>
                                @if ($teammate->isOwnerOfTeam($team))
                                    <span class="badge badge-success">Team Owner</span>
                                @else
                                    <span class="badge badge-primary">Team Member</span>
                                @endif
                            </td>
                            <td>
                                <button rel="buttonTxtTooltip" data-toggle="tooltip" data-placement="top" title="Kick User" type="button" class="btn btn-danger btn-sm"><i class="fas fa-bolt"></i></button>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>
        @else

            <div class="alert alert-warning">

                <span><i class="fas fa-exclamation-triangle"></i> <b>There don't seem to be any teammates here!</b></span>
                <p>Start inviting some people and grow your team.</p>

            </div>

        @endif

        <x-slot name="modalFooter"></x-slot>

    </x-modal>

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
                    <button type="button" class="btn btn-success ml-2" onclick="$('#editTeam').submit()"><i class="fas fa-save"></i> Save and Close</button>
                    <button type="button" class="btn btn-warning ml-2" onclick="$('#userlist_modal').modal('show')"><i class="fas fa-users"></i> Team Members</button>
                    <button type="button" class="btn btn-danger ml-2" onclick="location.href='{{ route('teams.index') }}'"><i class="far fa-trash-alt"></i> Cancel</button>
                </div>

            </div>

        </div>


        <div class="col">

            <div class="card">

                <div class="card-header">
                    <div class="card-title"><h4>Team Vacancies</h4></div>
                </div>

                <div class="card-body">

                    <span class="text-muted"><i class="fas fa-info-circle"></i> The vacancies you select determine what applications your team members see. All applications under the vacancies you choose will be displayed.</span>
                    
                    <form>

                        <select id="assocVacancies" name="assocVacancies" multiple="multiple">

                            @foreach($vacancies as $vacancy)

                                <option value="{{ $vacancy->id }}">{{ $vacancy->vacancyName }}</option>

                            @endforeach

                        </select>

                    </form>

                </div>

            </div>

        </div>


    </div>

@stop