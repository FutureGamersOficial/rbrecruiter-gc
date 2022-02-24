@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Member absence requests'))

@section('content_header')

    <h4>{{__('Human Resources')}} / {{ __('Reviewer') }} / {{__('Absence management')}}</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('content')


    <div class="row">
        <div class="col">

            <x-alert alert-type="info">
                <p class="text-bold"><i class="fas fa-info-circle"></i> {{ __('What is a leave of absence?') }}</p>

                <p>{{ __('A leave of absence is a time period in which an employee takes personal time off, for a multitude of reasons. It\'s a prolonged, authorized absence form work and/or other duties, communicated in advance, usually via letter or via an HR system.') }}</p>

                <p>{{ __('Here, you\'ll be able to view and approve leave requests from staff members. Notifications are sent out to ensure the right people know about this leave in advance. Staff members may ignore declined leave requests, however, their time off will be considered as a period of inactivity (no-show).') }}</p>
            </x-alert>
        </div>
    </div>

    <div class="row">

        <div class="col">
            <div class="card bg-gray-dark">

                <div class="card-header bg-indigo">

                    <div class="card-title"><h4 class="text-bold">{{__('Leave of absence requests')}}</h4></div>

                </div>

                <div class="card-body">
                    @if (!$absences->isEmpty())
                        <table class="table table-borderless table-active">

                            <thead>
                            <tr>
                                <th>{{__('Requesting user')}}</th>
                                <th>{{__('Reviewing admin')}}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Request date') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($absences as $absence)
                                <tr>
                                    <td>{{ $absence->requester->name }}</td>
                                    <td><span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> {{ __('None yet') }}</span></td>
                                    <td>
                                        @switch($absence->getRawOriginal('status'))

                                            @case('PENDING')
                                            <span class="badge badge-warning"><i class="fas fa-clock"></i> {{ __('Pending') }}</span>
                                            @break

                                            @case('APPROVED')
                                            <span class="badge badge-success"><i class="far fa-thumbs-up"></i> {{ __('Approved') }}</span>
                                            @break

                                            @case('DECLINED')
                                            <span class="badge badge-danger"><i class="far fa-thumbs-down"></i> {{ __('Declined') }}</span>
                                            @break

                                            @case('CANCELLED')
                                            <span class="badge badge-secondary"><i class="fas fa-ban"></i> {{ __('Cancelled') }}</span>
                                            @break

                                            @case('ENDED')
                                            <span class="badge badge-info"><i class="fas fa-history"></i> {{ __('Ended') }}</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>{{ $absence->created_at }}</td>
                                    <td><a href="{{ route('absences.show', ['absence' => $absence->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-search"></i> {{ __('Review') }}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">

                            <i class="fas fa-exclamation-triangle"></i><span> {{__('No requests')}}</span>
                            <p>
                                {{__('You haven\'t submitted any requests yet! Remember that you can only have one active request.')}}
                            </p>

                        </div>
                    @endif
                </div>

                <div class="card-footer">
                    <a href="{{ route('absences.create') }}"><button class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> New request</button></a>
                </div>

            </div>
        </div>

    </div>


@stop
