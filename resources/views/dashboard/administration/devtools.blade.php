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
        <form method="POST" id="forceEval" action="{{route('devToolsForceVoteCount')}}">
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

        <div class="col">

            <x-card id="tools" card-title="Event Management" footer-style="text-center">

                <x-slot name="cardHeader">

                </x-slot>
                    <button type="button" class="btn btn-danger" onclick="$('#confirmForceEventDispatch').modal('show')">{{__('messages.override_votes')}}</button>
                    <button type="button" class="btn btn-warning ml-3">{{__('messages.artisan_evaluate')}}</button>

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
