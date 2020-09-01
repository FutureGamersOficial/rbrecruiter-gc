@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.view_app.title'))

@section('content_header')

    <h4>{{__('messages.application_m.title')}} / {{__('messages.view_app.viewing_app', ['user' => $application->user->name])}}</h4>

@stop

@section('css')

    <link rel="stylesheet" href="/css/mixed.css">
    <link rel="stylesheet" href="/css/viewapplication.css">
    <link rel="stylesheet" href="/css/comments.css">
    <!-- TODO: Move to Mix + Webpack  -->


@stop

@section('js')

    <script type="text/javascript" src="/js/app.js"></script>
    <x-global-errors></x-global-errors>
    @if (!$canVote && Auth::user()->can('applications.vote') && $application->applicationStatus == 'STAGE_PEERAPPROVAL')
        <script>
            toastr.info('{{__('messages.view_app.cantvote')}}', '{{__('messages.warn')}}')
        </script>
    @endif

@stop

@section('content')

        @if (!is_null($application->appointment))

            @canany('applications.view.all', 'appointments.*')

                <x-modal id="notes" modal-label="notes" modal-title="Shared Notepad" include-close-button="true">

                    <form id="meetingNotes" method="POST" action="{{route('saveNotes', ['application' => $application->id])}}">
                        @csrf
                        @method('PATCH')
                        <textarea name="noteText" rows="5" class="form-control">{{$application->appointment->meetingNotes ?? __('messages.view_app.no_notes')}}</textarea>
                    </form>
                    <p class="text-muted text-sm">{{__('messages.last_updated')}} @ {{$application->appointment->updated_at}}</p>

                    <x-slot name="modalFooter">
                        <button type="button" class="btn btn-success" onclick="document.getElementById('meetingNotes').submit()"><i class="far fa-paper-plane"></i> {{__('messages.save_exit')}}</button>
                    </x-slot>
                </x-modal>

            @endcanany
        @endif

        @role('hiringManager')

            <x-modal id="denyApplication" modal-label="denyApplicationLabel" modal-title="{{__('messages.reusable.confirm')}}" include-close-button="true">

                <p>{{__('messages.view_app.deny_confirm')}}</p>
                <p class="text-muted">{{__('messages.view_app.deny_confirm_consequence')}}</p>

                <x-slot name="modalFooter">

                    <form id="updateApplication" action="{{route('updateApplicationStatus', ['application' => $application->id, 'newStatus' => 'deny'])}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger">{{__('messages.view_app.deny_confirm_btn')}}</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.modal_close')}}</button>

                </x-slot>

            </x-modal>

        @endhasrole

    <div class="row">

      <div class="col">

        <div class="alert alert-warning alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{__('messages.view_app.form_updated_alert')}}
        </div>

      </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{$formStructure->formName}}</div>
                </div>

                <div class="card-body">
                    @foreach($structuredResponses['responses'] as $content)

                        <div class="mt-4 mb-3">

                            <h5>{{$content['title']}}</h5>
                            <p>{{$content['response']}}</p>

                        </div>

                    @endforeach

                </div>
            </div>

        </div>

        <!-- TODO: Simplify logic by using switches, as well as a single Gate check -->
        <div class="col">

            <div class="row">

                <div class="col">

                    <div class="card bg-gray">

                        <div class="card-header bg-gradient-gray">
                            <div class="card-title">{{__('messages.view_app.context_info')}}</div>
                        </div>

                        <div class="card-body">

                            <p><b>{{__('messages.application_m.applicant_name')}} </b> <span class="badge badge-primary">{{$application->user->name}}</span></p>
                            @if (Auth::user()->hasRole('hiringManager'))
                                <p><b>{{__('messages.view_app.appl_ip')}}</b> <span class="badge badge-primary">{{$application->user->originalIP}}</span></p>
                            @endif
                            <p><b>{{__('messages.application_m.application_date')}}</b> <span class="badge badge-primary">{{$application->created_at}}</span></p>
                            <p><b>{{__('messages.last_updated')}}</b><span class="badge badge-primary">{{$application->updated_at}}</span></p>
                            <p><b>{{__('messages.view_app.appl_for')}}</b> <span class="badge badge-primary">{{$vacancy->vacancyName}}</span></p>
                            <p class="mt-2"><b>{{__('messages.view_app.currentstatus')}}</b>
                                @switch($application->applicationStatus)

                                    @case('STAGE_SUBMITTED')
                                        <span class="badge badge-warning">{{__('messages.application_m.outstanding_sm')}}</span>
                                        @break

                                    @case('STAGE_PEERAPPROVAL')
                                        <span class="badge badge-primary">{{__('messages.user.peer_approval')}}</span>
                                    @break

                                    @case('STAGE_INTERVIEW')
                                        <span class="badge badge-primary">{{__('messages.application_m.pending_int')}}</span>
                                    @break

                                    @case('STAGE_INTERVIEW_SCHEDULED')
                                        <span class="badge badge-primary"><i class="fas fa-clock"></i> {{__('messages.application_m.interview_s')}}</span>
                                    @break

                                    @case('APPROVED')
                                        <span class="badge badge-success"><i class="fa fa-check-double"></i> {{__('messages.application_m.approved')}}</span>
                                    @break

                                    @case('DENIED')
                                        <span class="badge badge-danger"><i class="fa fa-ban"></i> {{__('messages.application_m.denied')}}</span>
                                    @break



                                @endswitch
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <div class="row">

                <div class="col">

                    @if ($application->applicationStatus == 'STAGE_SUBMITTED' && Auth::user()->hasRole('hiringManager'))

                        <div class="card bg-gray">
                            <div class="card-header bg-gradient-gray">

                                <div class="card-title">{{__('messages.view_app.decisionmod')}}</div>

                            </div>

                            <div class="card-body text-center" style="white-space: nowrap">

                                <div class="row">


                                    <div class="col mr-5">
                                        <button type="button" class="btn btn-danger" onclick="$('#denyApplication').modal('show')" {{($application->applicationStatus == 'DENIED') ? 'disabled' : ''}}><i class="fas fa-arrow-left"></i> {{__('messages.view_app.denyapp')}}</button>
                                    </div>

                                    <div class="col">
                                        <form method="POST" action="{{route('updateApplicationStatus', ['application' => $application->id, 'newStatus' => 'interview'])}}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success" {{($application->applicationStatus == 'DENIED') ? 'disabled' : ''}}><i class="fas fa-arrow-right" ></i> {{__('messages.view_app.nextstage')}}</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                    @endif


                </div>

            </div>

            @if ($application->applicationStatus == 'STAGE_INTERVIEW' && Auth::user()->hasRole('hiringManager'))

                <div class="row">

                    <div class="col">

                        <x-card id="appointmentCard" card-title="Schedule An Interview" footer-style="text-center">

                            <x-slot name="cardHeader">

                            </x-slot>

                            <form id="scheduleAppointment" action="{{route('scheduleAppointment', ['application' => $application->id])}}" method="POST">

                                @csrf

                                <label for="appointmentDescription">{{__('messages.view_app.appointment_desc')}}</label>
                                <input type="text" class="form-control" name="appointmentDescription">

                                <label for="appointmentDateTime">{{__('messages.view_app.int_date_time')}}</label>
                                <input type="text" class="form-control" name="appointmentDateTime" id="appointmentDateTime">
                                <p class="text-muted text-sm">{{__('messages.view_app.choosedate')}}</p>

                                <label for="appointmentLocation">{{__('messages.view_app.appointment_loc')}}</label>
                                <select class="custom-select" id="appointmentLocation" name="appointmentLocation">

                                    <option value="nil" disabled>{{__('messages.view_app.pref_platform')}}</option>
                                    <option value="ZOOM">Zoom</option>
                                    <option value="DISCORD">Discord</option>
                                    <option value="SKYPE">Skype</option>
                                    <option value="MEET">Google Meet</option>
                                    <option value="TEAMSPEAK">Teamspeak</option>

                                </select>
                                <p class="text-muted text-sm">{{__('messages.view_app.coming_soon_int')}}</p>
                            </form>

                            <x-slot name="cardFooter">
                                <button type="button" class="btn btn-warning text-center" onclick="document.getElementById('scheduleAppointment').submit()"><i class="fas fa-clock"></i> {{__('messages.reusable.schedule')}}</button>
                            </x-slot>

                        </x-card>

                    </div>

                </div>

            @endif

            @if ($application->applicationStatus == 'STAGE_INTERVIEW_SCHEDULED')

                <div class="row">

                    <div class="col">

                        <x-card id="scheduleInfo" card-title="Appointment Information" footer-style="text-center">

                            <x-slot name="cardHeader"></x-slot>

                            <p class="text-muted">{{$application->appointment->appointmentDescription}}</p>

                            <p><b>{{__('messages.view_app.scheduled_for')}}</b> <span class="badge badge-primary">{{$application->appointment->appointmentDate}}</span></p>
                            <p><b>{{__('messages.reusable.status')}}: </b> <span class="badge badge-primary">{{Str::ucfirst(Str::lower($application->appointment->appointmentStatus))}}</span></p>
                            <p><b>{{__('messages.reusable.platform')}}:</b> <span class="badge badge-primary">{{Str::ucfirst(Str::lower($application->appointment->appointmentLocation))}}</span></p>

                            <x-slot name="cardFooter">

                                @can('appointments.schedule.edit')
                                    <form style="white-space: nowrap;display:inline-block" class="footer-button" action="{{route('updateAppointment', ['application' => $application->id, 'status' => 'concluded'])}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">{{__('messages.view_app.finish_meeting')}}</button>
                                    </form>
                                @endcan

                                @can('applications.vote')
                                    <button class="btn btn-warning mr-3" onclick="$('#notes').modal('show')">{{__('messages.view_app.view_notes')}}</button>
                                @endcan

                            </x-slot>

                        </x-card>

                    </div>

                </div>

            @endif

            @if ($application->applicationStatus == 'STAGE_PEERAPPROVAL' && Auth::user()->can('applications.vote'))

                <x-card id="peerApproval" card-title="{{__('messages.view_app.vote_app')}}" footer-style="text-center">

                    <x-slot name="cardHeader"></x-slot>

                    <p class="text-muted">{{__('messages.view_app.vote_explainer.line1')}}</p>
                    <p class="text-muted">{{__('messages.view_app.vote_explainer.line2')}}</p>

                    <p class="text-muted">{{__('messages.view_app.vote_explainer.line3')}}</p>

                    <x-slot name="cardFooter">

                        @if($canVote)

                            <form class="d-inline-block" method="POST" action="{{route('voteApplication', ['application' => $application->id])}}">
                                @csrf
                                <input type="hidden" name="voteType" value="VOTE_APPROVE">
                                <button type="submit" class="btn btn-sm btn-warning">{{__('messages.view_app.vote_approve')}}</button>
                            </form>
                            <form class="d-inline-block" method="POST" action="{{route('voteApplication', ['application' => $application->id])}}">
                                @csrf
                                <input type="hidden" name="voteType" value="VOTE_DENY">
                                <button type="submit" class="btn btn-sm btn-warning">{{__('messages.view_app.vote_deny')}}</button>
                            </form>

                        @endif

                        <button type="button" class="btn btn-sm btn-warning {{($canVote) ? 'ml-5' : ''}}" onclick="$('#notes').modal('show')">{{__('messages.view_app.m_notes')}}</button>
                    </x-slot>

                </x-card>

            @endif

            @can('applications.view.all')

                <div class="row">

                    <div class="col text-center">

                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{route('staffPendingApps')}}'">{{__('messages.view_app.view_more')}}</button>

                    </div>

                </div>

            @endcan

        </div>

    </div>

    @hasanyrole('reviewer|hiringManager|admin')
      @if (!Auth::user()->is($application->user))
        <div class="row mb-3 mt-2">

            <h3>{{__('messages.view_app.comments')}} ({{$comments->count()}})</h3>

        </div>

        <div class="row">

            <div class="col">

                @if ($comments->isEmpty())

                    <div class="alert alert-warning">
                        <i class="fas fa-question"></i> <b></b>


                        <p>{{__('messages.view_app.no_comments_exp')}}</p>


                    </div>
                @endif

            </div>

        </div>


                @if (!$comments->isEmpty())

                        @foreach($comments as $comment)
                          <div class="row mt-3 mb-3">
                            <div class="col-md-2">

                                <div class="text-center">
                                    @if($application->user->avatarPreference == 'gravatar')
                                        <img class="profile-user-img img-fluid img-circle" src="https://gravatar.com/avatar/{{md5($comment->user->email)}}" alt="User profile picture">
                                    @else
                                        <img class="profile-user-img img-fluid img-circle" src="https://crafatar.com/avatars/{{$comment->user->uuid}}" alt="User profile picture">
                                    @endif
                                </div>

                            </div>

                            <div class="card comment">

                                <div class="card-header comment-header">

                                    <!-- Carbon has to be set to translate diffs, can't do directly. -->
                                    <h1 class="commenter">{{$comment->user->name}} &#9679; {{Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</h1>

                                </div>


                                <div class="card-body">

                                    {{$comment->text}}

                                </div>

                                @if(Auth::user()->is($comment->user) || Auth::user()->hasRole('admin'))

                                    <div class="card-footer comment-footer">

                                        <form method="POST" id="deleteComment" action="{{route('deleteApplicationComment', ['comment' => $comment->id])}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>

                                        </form>

                                    </div>

                                @endif

                            </div>
                          </div>

                        @endforeach
                @endif

            <!-- display comments here -->

        <div class="row mt-5">

          <div class="col-md-2">

            <div class="text-center">
                @if($application->user->avatarPreference == 'gravatar')
                    <img class="profile-user-img img-fluid img-circle" src="https://gravatar.com/avatar/{{md5(Auth::user()->email)}}" alt="User profile picture">
                @else
                    <img class="profile-user-img img-fluid img-circle" src="https://crafatar.com/avatars/{{Auth::user()->uuid}}" alt="User profile picture">
                @endif
            </div>

          </div>

          <div class="col">
            <div class="card border-top border-bottom">

                <div class="card-body">

                    <form id="newComment" method="POST" action="{{route('addApplicationComment', ['application' => $application->id])}}">

                        @csrf

                        <textarea id="comment" name="comment" class="form-control" id="commentText"></textarea>

                    </form>

                    <div class="row">

                        <div class="col text-left">
                            <p class="text-sm text-muted">{{__('messages.view_app.commenting_as', ['username' => Auth::user()->name ])}}</p>
                        </div>


                        <div class="col text-right">

                            <p class="text-sm text-muted"><span id="charcount">0</span>/600 {{__('messages.view_app.max_chars')}}</p>

                        </div>

                    </div>

                </div>

                <div class="card-footer text-right">

                    <button type="button" id="submitComment" class="btn btn-sm btn-secondary">{{__('messages.view_app.post')}}</button>

                </div>

            </div>
         </div>

        </div>
      @endif
    @endhasanyrole

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
