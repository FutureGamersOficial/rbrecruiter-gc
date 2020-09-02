@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.application_m.int_applications'))

@section('content_header')

    <h4>{{__('messages.reusable.my_acc')}} / {{__('messages.application_m.int_applications')}}</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="callout callout-warning">
                <h5>{{__('messages.user.app_process.title')}}</h5>

                <p>{{__('messages.user.app_process.line1')}}</p>
                <p>{{__('messages.user.app_process.line2')}}</p>
            </div>

            <div class="alert alert-info">
                <b><i class="fa fa-info-circle"></i> {{__('messages.user.account_standing')}}</b>

                <p>{{__('messages.user.account_eligibility', ['eligibility' => ($isEligibleForApplication) ? __('messages.eligible') : __('messages.ineligible')])}}</p>

                @if (!$isEligibleForApplication)
                    <p>{{__('messages.user.days_remaining_acc_alt', ['days' => '<b>' . $eligibilityDaysRemaining .'</b>'])}}</p>
                @endif

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('messages.user.my_ongoingapps')}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0"> <!-- move to dedi css -->

                    @if (!$applications->isEmpty())

                        <table class="table" style="white-space: nowrap">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{__('messages.application_m.applicant')}}</th>
                                <th>{{__('messages.application_m.application_date')}}</th>
                                <th>{{__('messages.last_updated')}}</th>
                                <th style="width: 40px">{{__('messages.reusable.status')}}</th>
                                <th style="width: 40px">{{__('messages.reusable.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($applications as $application)

                                <tr>
                                    <td>{{$application->id}}</td>
                                    <td>{{Auth::user()->name}}</td>
                                    <td>{{$application->created_at}}</td>
                                    <td>{{$application->updated_at}}</td>
                                    <td>
                                        @switch($application->applicationStatus)

                                            @case('STAGE_SUBMITTED')
                                            <span class="badge badge-success"><i class="fas fa-paper-plane"></i> {{__('messages.user.submitted')}}</span>
                                            @break

                                            @case('STAGE_PEERAPPROVAL')
                                            <span class="badge badge-warning"><i class="fas fa-users"></i> {{__('messages.user.peer_approval')}}</span>
                                            @break

                                            @case('STAGE_INTERVIEW')
                                            <span class="badge badge-info"><i class="fa fa-microphone-alt"></i> {{__('messages.application_m.interview_p')}}</span>
                                            @break

                                            @case('STAGE_INTERVIEW_SCHEDULED')
                                            <span class="badge badge-warning"><i class="fa fa-clock"></i> {{__('messages.application_m.interview_s')}}</span>
                                            @break

                                            @case('APPROVED')
                                            <span class="badge badge-success"><i class="fa fa-check-double"></i> {{__('messages.application_m.approved')}}</span>
                                            @break

                                            @case('DENIED')
                                            <span class="badge badge-danger"><i class="fa fa-ban"></i> <b>{{__('messages.application_m.denied')}}</b></span>
                                            @break

                                            @default
                                            <span class="badge badge-danger"><i class="fa fa-question"></i> {{__('messages.application_m.unknown_stat')}}</span>
                                        @endswitch
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-success" onclick="window.location.href='{{route('showUserApp', ['application' => $application->id])}}'"><i class="fa fa-eye"></i> {{__('messages.reusable.view')}}</button>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>

                    @else

                        <div class="alert alert-warning">
                            <p><i class="fa fa-info-circle"></i> <b>{{__('messages.user.nothing_to_show')}}</b></p>
                            <p>{{__('messages.user.nothing_to_show_exp')}}</p>
                        </div>

                    @endif
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                    <button type="button" class="btn btn-default mr-2">Back</button>

                </div>
            </div>

        </div>

    </div>

@stop
@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
