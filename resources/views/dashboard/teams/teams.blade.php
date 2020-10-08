@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.teams.m_teams_page'))

@section('content_header')
    <h1>{{config('app.name')}} / {{__('messages.teams.m_teams_page')}}</h1>
@stop

@section('js')

    <x-global-errors></x-global-errors>

@endsection

@section('content')


<x-modal id="newTeamModal" modal-label="newTeamModalLabel" modal-title="New team" include-close-button="true">

    <div class="row">
        <div class="col offset-3">
            <img src="/img/new_team.svg" height="220px" width="220px" alt="New Team illustration">
        </div>
    </div>

    <form action="{{ route('teams.store') }}" method="POST" id="newTeamForm">

        @csrf
        
        <div class="text-center">
            <input type="text" id="teamName" class="form-control" required name="teamName">
        </div>

        <p class="text-muted text-sm">This is the name team members will see.</p>

    </form>

    <x-slot name="modalFooter">

        <button type="button" class="btn btn-success" onclick="$('#newTeamForm').submit()"><i class="fas fa-check"></i> Create</button>

    </x-slot>

</x-modal>



<div class="row">

    <div class="col-md-4 offset-4 text-center">

        <img src="/img/team.svg" height="230px" width="230px" alt="Team illustration">

    </div>

</div>


<div class="row">


    <div class="col">


        <div class="card bg-gray-dark">

            <div class="card-header bg-indigo">


                <div class="row">

                    <div class="col">

                        <div class="card-title"><h4>{{ __('messages.teams.m_teams_page') }} <span class="badge badge-warning"><i class="fas fa-check-circle"></i> {{ (Auth::user()->currentTeam) ? Auth::user()->currentTeam->name : 'Select a team' }}</span></h4></div>
                        

                    </div>
                </div>

            </div>

            <div class="card-body">

                @if (!$teams->isEmpty())

                    <table class="table-borderless table-active table">


                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Team Owner</th>
                                <th>Team Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($teams as $team)
                            
                                <tr>
                                    <td>{{ $team->id }}</td>
                                    <td>{{ $team->owner_id }}</td>
                                    <td>{{ $team->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm ml-2" onclick="location.href='{{ route('teams.edit', ['team' => $team->id]) }}'"><i class="fas fa-cogs"></i> Settings</button>
                                        <button onclick="location.href='{{ route('switchTeam', ['team' => $team]) }}'" rel="buttonTxtTooltip" data-placement="top" data-toggle="tooltip" title="Select your active team (for dasboard context, etc)" type="button" class="btn btn-warning btn-sm ml-2"><i class="fas fa-random"></i> Switch To</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>


                    </table>

                @else

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> <b> There don't seem to be any teams here</b>
                        <p>Have you tried creating or joining a team? You may also click an invite link if you've been invited.</p>
                    </div>

                @endif


            </div>

            <div class="card-footer">

                <button type="button" class="btn btn-success btn-sm ml-3" onclick="$('#newTeamModal').modal('show')"><i class="fas fa-plus-circle"></i> New team</button>
                <button type="button" class="btn btn-warning btn-sm ml-3"><i class="fas fas fa-long-arrow-alt-right"></i> Team Dashboard</button>

            </div>

        </div>


    </div>


</div>


@stop
