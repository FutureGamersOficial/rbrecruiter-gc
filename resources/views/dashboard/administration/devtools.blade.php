@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.devoptions'))

@section('content_header')

    <h4>{{__('messages.adm')}} / {{__('messages.devtools')}}</h4>

@stop

@section('js')
    <x-global-errors></x-global-errors>
@stop

@section('content')

    <x-modal id="confirmForceEventDispatch" modal-label="confirmForceEventDispatch" modal-title="{{__('messages.choose_app')}}" include-close-button="true">

        <p>{{__('messages.forceeval')}}</p>
        <form method="POST" id="forceEval" action="{{route('devForceApprovalEvent')}}">
            @csrf
            <select name="application" class="custom-select">
                @if(!$applications->isEmpty())
                    @foreach($applications as $application)

                        <option value="{{$application->id}}">{{__('messages.appid')}} {{$application->id}} ({{$application->user->name}})</option>

                    @endforeach
                @else
                    <option value="null" disabled>{{__('messages.no_valid_app')}}</option>
                @endif
            </select>

        </form>

        <x-slot name="modalFooter">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('forceEval').submit()">{{__('messages.dispatch_event')}}</button>
        </x-slot>

    </x-modal>

    <div class="row">
        <div class="col">

            <div class="alert alert-warning">

                <i class="fa fa-exclamation-triangle"></i> <b>{{__('messages.warn')}}</b>
                <p>{{__('messages.devtools_warn')}}</p>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col text-center">

            <x-card id="tools" card-title="Commands & Actions" footer-style="text-center">

                <x-slot name="cardHeader">

                </x-slot>
                    <button data-toggle="tooltip" data-placement="top" title="Dispatches a specific event for the selected application" type="button" class="btn btn-primary" onclick="$('#confirmForceEventDispatch').modal('show')"><i class="fas fa-bullhorn"></i> Dispatch application event</button>

                    <form name="evalvotes" method="post" action="{{ route('devForceEvaluateVotes') }}" class="d-inline">
                        @csrf
                        <button data-toggle="tooltip" data-placement="top" title="Counts and processes all backlogged votes, for all applications." type="submit" class="btn btn-primary ml-3"><i class="fas fa-redo"></i> Count all votes now</button>
                    </form>

                    <form name="purgebans" method="post" action="{{ route('devPurgeExpired') }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button data-toggle="tooltip" data-placement="top" title="Cleans the database of old, expired suspensions, therefore unbanning certain users." type="submit" class="btn btn-primary ml-3"><i class="far fa-trash-alt"></i> Purge expired bans</button>
                    </form>

                <x-slot name="cardFooter">
                    <p class="text-muted"> .</p>
                </x-slot>
            </x-card>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
