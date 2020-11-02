@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.application_m.int_applications'))

@section('content_header')

    <h4>{{__('messages.application_m.title')}} / {{__('messages.application_m.interview_q')}}</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$applications->count()}}</h3>
                    <p>{{__('messages.application_m.interview_q')}}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-microphone-alt"></i>
                </div>
            </div>

        </div>

        <div class="col">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$finishedCount}}</h3>
                    <p>{{__('messages.application_m.finished_int')}}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">

               <div class="card-header">
                   <div class="card-title"><h3>{{__('messages.application_m.schedule_int')}}</h3></div>
               </div>

                <div class="card-body">

                    @if (!$applications->isEmpty())

                        <table class="table" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>{{__('messages.application_m.interviewee')}}</th>
                                <th>{{__('messages.reusable.status')}}</th>
                                <th>{{__('messages.reusable.actions')}}</th>
                            </tr>

                            </thead>

                            <tbody>

                            @foreach($applications as $application)

                                <tr>
                                    <td>{{$application->id}}</td>
                                    <td>{{$application->user->name}}</td>
                                    <td><span class="badge-warning badge">{{($application->applicationStatus == 'STAGE_INTERVIEW') ? __('messages.application_m.pending_int') : __('messages.application_m.unknown_stat')}}</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='{{route('showUserApp', ['application' => $application->id])}}'"><i class="fa fa-eye"></i> {{__('messages.reusable.view')}}</button>
                                        <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-clock"></i> {{__('messages.application_m.schedule')}}</button>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="alert alert-danger">

                            <b><i class="fa fa-exclamation-triangle"></i> {{__('messages.application_m.no_apps_pending_int')}}</b>
                            <p>{{__('messages.application_m.no_apps_pending_int_exp')}}</p>
                        </div>

                    @endif

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card">

                <div class="card-header">

                    <div class="card-title"><h3>{{__('messages.application_m.upcoming_int')}}</h3></div>

                </div>

                <div class="card-body">

                    @if (!$upcomingApplications->isEmpty())
                        <table class="table" style="white-space: nowrap">

                            <thead>

                            <tr>

                                <th>#</th>
                                <th>{{__('messages.application_m.interviewee')}}</th>
                                <th>{{__('messages.reusable.status')}}</th>
                                <th>{{__('messages.reusable.datetime')}}</th>
                                <th>{{__('messages.reusable.location')}}</th>
                                <th>{{__('messages.reusable.actions')}}</th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach($upcomingApplications as $upcomingApp)

                                <tr>
                                    <td>{{$upcomingApp->id}}</td>
                                    <td>{{$upcomingApp->user->name}}</td>
                                    @if (is_null($upcomingApp->appointment))
                                        <td><span class="badge badge-warning"><i class="fa fa-question-circle"></i>{{__('messages.application_m.pending_schedule')}}</span></td>
                                        <td>{{__('messages.reusable.none_yet')}}</td>
                                        <td><span class="badge badge-warning"><i class="fa fa-question-circle"></i>{{__('messages.application_m.pending_int')}}</span></td>
                                    @else
                                        <td><span class="badge badge-success"><i class="fa fa-check"></i> {{ucfirst(strtolower($upcomingApp->appointment->appointmentStatus))}}</span></td>
                                        <td>{{$upcomingApp->appointment->appointmentDate}}</td>
                                        <td><span class="badge badge-success"><i class="fa fa-check"></i> {{ucfirst(strtolower($upcomingApp->appointment->appointmentLocation))}}</span></td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='{{route('showUserApp', ['application' => $upcomingApp->id])}}'"><i class="fa fa-eye"></i> {{__('messages.reusable.view_c')}}</button>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <x-alert alert-type="danger">
                            <p><i class="fa fa-exclamation-triangle"></i><b>{{__('messages.application_m.no_upcoming')}}</b></p>
                            {{__('messages.application_m.no_upcoming_exp')}}
                        </x-alert>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="row mr-5">

        <div class="col text-center">

            <button type="button" class="btn btn-success mr-3" onclick="window.location.href='{{route('staffPendingApps')}}'">{{__('messages.application_m.view_outstanding_queue')}}</button>
            <button type="button" class="btn btn-success mr-3" onclick="window.location.href='{{route('peerReview')}}'">{{__('messages.application_m.view_approval_queue')}}</button>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
