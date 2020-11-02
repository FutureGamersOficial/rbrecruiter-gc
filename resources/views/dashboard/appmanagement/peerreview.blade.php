@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.application_m.p_review'))

@section('content_header')

    <h4>{{__('messages.application_m.title')}} / {{__('messages.application_m.p_review')}}</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="callout callout-info">

                <h4>{{__('messages.application_m.voting_reminder.title')}}</h4>

                <p>{{__('messages.application_m.voting_reminder.line1')}}</p>
                <p>{{__('messages.application_m.voting_reminder.line2')}}</p>

                <p>{{__('messages.application_m.voting_reminder.line3')}}</p>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-header">
                    <div class="card-title"><h3>{{__('messages.v_backlog')}}</h3></div>
                </div>

                <div class="card-body">

                    @if(!$applications->isEmpty())
                        <table class="table" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>{{__('messages.application_m.applicant_name')}}</th>
                                <th>{{__('messages.last_updated')}}</th>
                                <th>{{__('messages.reusable.status')}}</th>
                                <th>{{__('messages.reusable.actions')}}</th>
                            </tr>

                            </thead>

                            <tbody>


                            @foreach($applications as $application)

                                <td>{{$application->id}}</td>
                                <td>{{$application->user->name}}</td>
                                <td>{{$application->created_at}}</td>
                                <td><span class="badge badge-warning">{{($application->applicationStatus == 'STAGE_PEERAPPROVAL') ? __('messages.application_m.p_review') : __('messages.application_m.unknown_stat')}}</span></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" onclick="window.location.href='{{route('showUserApp', ['application' => $application->id])}}'"><i class="far fa-clipboard"></i> {{__('messages.application_r.review')}}</button>
                                </td>

                            @endforeach

                            </tbody>

                        </table>
                    @else
                        <x-alert alert-type="warning">
                            <p class="text-bold"><i class="fa fa-exclamation-triangle"></i> {{__('messages.application_m.no_pending_review')}}</p>

                            {{__('messages.application_m.no_pending_review_exp')}}
                        </x-alert>
                    @endif

                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
