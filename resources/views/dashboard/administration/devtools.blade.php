@extends('adminlte::page')

@section('title', 'Raspberry Network | Developer Options')

@section('content_header')

    <h4>Administration / Developer Tools</h4>

@stop

@section('js')
    <x-global-errors></x-global-errors>
@stop

@section('content')

    <x-modal id="confirmForceEventDispatch" modal-label="confirmForceEventDispatch" modal-title="Choose an application" include-close-button="true">

        <p>Please choose an application to force re-evaluation</p>
        <form method="POST" id="forceEval" action="{{route('devToolsForceVoteCount')}}">
            @csrf
            <select name="application" class="custom-select">
                @if(!$applications->isEmpty())
                    @foreach($applications as $application)

                        <option value="{{$application->id}}">Application ID {{$application->id}} ({{$application->user->name}})</option>

                    @endforeach
                @else
                    <option value="null" disabled>There are no valid applications</option>
                @endif
            </select>

        </form>

        <x-slot name="modalFooter">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('forceEval').submit()">Dispatch event now</button>
        </x-slot>

    </x-modal>

    <div class="row">
        <div class="col">

            <div class="alert alert-warning">

                <i class="fa fa-exclamation-triangle"></i> <b>Warning</b>
                <p>Do not use these options if you don't know what you're doing, even if you have access to this page.</p>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col">

            <x-card id="tools" card-title="Event Management" footer-style="text-center">

                <x-slot name="cardHeader">

                </x-slot>
                    <button type="button" class="btn btn-danger" onclick="$('#confirmForceEventDispatch').modal('show')">Override Vote Evaluation</button>
                    <button type="button" class="btn btn-warning ml-3">Artisan: Evaluate Votes Now</button>

                <x-slot name="cardFooter">
                    <p class="text-muted"> This panel may be also used to completely override the vote system in stalemate scenarios.</p>
                </x-slot>
            </x-card>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
