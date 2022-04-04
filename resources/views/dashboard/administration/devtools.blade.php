@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Development & debug tools'))

@section('content_header')

    <h4>{{__('Administration')}} / {{__('Developer Tools')}}</h4>

@stop

@section('js')
    <x-global-errors></x-global-errors>
@stop

@section('content')

    <x-modal id="confirmForceEventDispatch" modal-label="confirmForceEventDispatch" modal-title="{{__('Choose an application to override')}}" include-close-button="true">

        <p>{{__('Please choose an application to force approve')}}</p>
        <p>{{ __('Note that this process overrides users\'s votes.') }}</p>
        <form method="POST" id="forceEval" action="{{route('devForceApprovalEvent')}}">
            @csrf
            <select name="application" class="custom-select">
                @if(!$applications->isEmpty())
                    @foreach($applications as $application)

                        <option value="{{$application->id}}">{{__('Application ID')}} {{$application->id}} ({{$application->user->name}})</option>

                    @endforeach
                @else
                    <option value="null" disabled>{{__('There are no valid applications')}}</option>
                @endif
            </select>

        </form>

        <x-slot name="modalFooter">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('forceEval').submit()">{{__('Override now')}}</button>
        </x-slot>

    </x-modal>

    <x-modal id="confirmDispatchRejection" modal-label="confirmDispatchRejection" modal-title="{{__('Choose an application')}}" include-close-button="true">

        <p>{{__('Please choose an application to force reject')}}</p>
        <p>{{ __('Note that this process overrides users\'s votes, and it also ignores any stages the application may be in.') }}</p>
        <form method="POST" id="forceRejection" action="{{route('devForceRejectionEvent')}}">
            @csrf
            <select name="application" class="custom-select">
                @if(!$rejectApplications->isEmpty())
                    @foreach($rejectApplications as $application)

                        <option value="{{$application->id}}">{{__('Application ID')}} {{$application->id}} ({{$application->user->name}}) ({{ $application->applicationStatus }})</option>

                    @endforeach
                @else
                    <option value="null" disabled>{{__('There are no valid applications')}}</option>
                @endif
            </select>

        </form>

        <x-slot name="modalFooter">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('forceRejection').submit()">{{__('Dispatch event now')}}</button>
        </x-slot>

    </x-modal>

    <div class="row">
        <div class="col">

            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle"></i> <b>{{__('Warning')}}</b>

                <p>{{__('These tools were intended for development purposes. Unless you know exactly what each command does, we recommend you don\'t use any of them.')}}</p>
            </div>

        </div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <x-card id="appCommands" card-title="{{ __('Application-specific commands') }}" footer-style="text-muted">

                <x-slot name="cardHeader">
                </x-slot>

                <div class="form-group d-block">
                    <button type="button" class="mb-3 btn btn-info" onclick="$('#confirmForceEventDispatch').modal('show')"><i class="fas fa-check-circle"></i> {{ __('Application Override: Approve') }}</button>
                    <button type="button" class="mt-3 btn btn-info" onclick="$('#confirmDispatchRejection').modal('show')"><i class="fas fa-ban"></i> {{ __('Application Override: Decline') }}</button>
                </div>

                <x-slot name="cardFooter">
                    <p><i class="fas fa-info-circle"></i> {{ __('This panel allows you to override statuses for specific applications. Overriding them will trigger the correct events as well. Note that this system entirely ignores the voting system because these statuses ignore all other logic.') }}</p>
                </x-slot>

            </x-card>
        </div>

        <div class="col">
            <x-card id="appCleaning" card-title="{{ __('Housekeeping') }}" footer-style="text-muted">

                <x-slot name="cardHeader">
                </x-slot>

                <div class="form-group d-block">
                    <form method="post" action="{{ route('devForceEvaluateVotes') }}">
                        @csrf
                        <button type="submit" class="mb-3 btn btn-info"><i class="fas fa-vote-yea"></i> {{ __('Run task: process pending votes') }}</button>
                    </form>

                    <form method="post" action="{{ route('devPurgeExpiredSuspensions') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="mb-3 btn btn-info"><i class="fas fa-users-cog"></i> {{ __('Run task: lift expired suspensions') }}</button>
                    </form>

                    <form method="post" action="{{ route('devPurgeExpiredAbsences') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="mb-3 d-block btn btn-info"><i class="fas fa-calendar-minus"></i> {{ __('Run task: end expired absence requests') }}</button>
                    </form>
                </div>

                <x-slot name="cardFooter">
                    <p><i class="fas fa-info-circle"></i> {{ __('Housekeeping jobs usually run once every day, but if one of them has failed for some reason, you can manually run them here.') }}</p>
                </x-slot>

            </x-card>
        </div>
    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
