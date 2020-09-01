@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.application_m.title'))

@section('content_header')

    <h4>{{__('messages.application_m.title')}} / {{__('messages.application_m.outstanding_apps')}}</h4>

@stop

@section('js')

    <script type="text/javascript" src="/js/app.js"></script>

@stop


@section('content')

    <div class="row">

        <div class="col">
            <div class="callout callout-info">
                <p>{{__('messages.application_m.no_outstanding')}}</p>
                <p>{{__('messages.application_m.no_outstanding_exp')}}</p>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-header">

                    <div class="card-title"><h4>{{__('messages.application_m.outstanding_apps')}}</h4></div>

                </div>

                <div class="card-body">

                    @if (!$applications->isEmpty())
                        <table class="table" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>{{__('messages.application_m.applicant_name')}}</th>
                                <th>{{__('messages.reusable.status')}}</th>
                                <th>{{__('messages.application_m.application_date')}}</th>
                                <th>{{__('messages.last_updated')}}</th>
                                <th>{{__('messages.reusable.status')}}</th>
                            </tr>

                            </thead>

                            <tbody>

                            @foreach($applications as $application)

                                <tr>

                                    <td>{{$application->id}}</td>
                                    <td>{{$application->user->name}}</td>
                                    <td><span class="badge badge-warning">{{($application->applicationStatus == 'STAGE_SUBMITTED') ? __('messages.application_m.outstanding_sm') : __('messages.application_m.unknown_stat')}}</span></td>
                                    <td>{{$application->created_at}}</td>
                                    <td>{{$application->updated_at}}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="window.location.href='{{route('showUserApp', ['application' => $application->id])}}'"><i class="fas fa-clipboard-check"></i> {{__('messages.application_r.review')}}</button>
                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>
                    @else

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i><b> {{__('messages.application_m.no_pending')}}</b>
                            <p>{{__('messages.application_m.no_pending_exp')}}</p>
                        </div>

                    @endif

                </div>

                <div class="card-footer text-center">

                    <button type="button" class="btn btn-success" onclick="window.location.href='{{route('pendingInterview')}}'">{{__('messages.application_m.view_interview_queue')}}</button>

                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
