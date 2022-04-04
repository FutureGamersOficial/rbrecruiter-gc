@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Viewing application'))

@section('content_header')

    <h4>{{__('Application Management')}} / {{__("Viewing :userNameValue's application", ['userNameValue' => $application->user->name])}}</h4>

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
            toastr.info('{{__('You cannot vote on this application anymore.')}}', '{{__('Warning')}}')
        </script>
    @endif

@stop

@section('content')

        @if (!is_null($application->appointment))

            @canany('applications.view.all', 'appointments.*')

                <x-modal id="notes" modal-label="notes" modal-title="{{__('Shared Notepad')}}" include-close-button="true">

                    <form id="meetingNotes" method="POST" action="{{route('saveNotes', ['application' => $application->id])}}">
                        @csrf
                        @method('PATCH')
                        <textarea name="noteText" rows="5" class="form-control">{{$application->appointment->meetingNotes ?? __('There are no notes yet. Add some!')}}</textarea>
                    </form>
                    <p class="text-muted text-sm">{{__('Last updated')}} @ {{$application->appointment->updated_at}}</p>

                    <x-slot name="modalFooter">
                        <button type="button" class="btn btn-success" onclick="document.getElementById('meetingNotes').submit()"><i class="far fa-paper-plane"></i> {{__('Save & Quit')}}</button>
                    </x-slot>
                </x-modal>

            @endcanany
        @endif

        @role('hiringManager')

            <x-modal id="denyApplication" modal-label="denyApplicationLabel" modal-title="{{__('Please Confirm')}}" include-close-button="true">

                <p>{{__('Are you sure you want to deny this application? Please keep in mind that this user will only be allowed to apply 30 days after their first application.')}}</p>
                <p class="text-muted">{{__('This action cannot be undone.')}}</p>

                <x-slot name="modalFooter">

                    <form id="updateApplication" action="{{route('updateApplicationStatus', ['application' => $application->id, 'newStatus' => 'deny'])}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-ban"></i> {{__('Confirm')}}</button>
                    </form>
                </x-slot>

            </x-modal>


        <x-modal id="cancelAppointmentModal" modal-label="cancelAppointmentModalLabel" modal-title="{{__('Cancel appointment?')}}" include-close-button="true">

            <div class="alert alert-warning">
                <p class="text-bold"><i class="fas fa-exclamation-triangle"></i> {{ __('Caution') }}</p>

                <p>{{__('Are you sure you want to cancel this appointment? The user will be notified of this via email, and you will be able to reschedule.')}}</p>
                <p>{{ __('Before you can cancel this appointment, you\'ll need to provide a reason in writing. ') }}</p>
            </div>

            <form id="confirmCancelAppointment" method="POST" action="{{ route('deleteAppointment', ['application' => $application->id]) }}">
                @method('DELETE')
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-comment"></i></span>
                    </div>
                    <input type="text" name="reason" id="reason" class="form-control" placeholder="{{ __('Cancellation reason...') }}" required>
                </div>
            </form>

            <x-slot name="modalFooter">
                <button type="button" class="btn btn-warning" onclick="$('#confirmCancelAppointment').submit()"><i class="fas fa-calendar-times"></i> {{ __('Finish cancelling appointment') }}</button>
            </x-slot>

        </x-modal>

        @endhasrole

    <div class="row">

      <div class="col">

        <div class="alert alert-warning alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{__('If this form has been updated, new fields and updated questions will not show up here!')}}
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

                            <p>{!! GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($content['response']) !!}</p>

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
                            <div class="card-title">{{__('Contextual information')}}</div>
                        </div>

                        <div class="card-body">

                            <p><b>{{__('Applicant Name')}} </b> <span class="badge badge-primary">{{$application->user->name}}</span></p>
                            @if (Auth::user()->hasRole('hiringManager'))
                                <p><b>{{__('Applicant IP Address')}}</b> <span class="badge badge-primary">{{ (!$shouldCollect) ? __('0.0.0.0 (censored)') : $application->user->originalIP }}</span></p>
                            @endif
                            <p><b>{{__('Application Date')}}</b> <span class="badge badge-primary">{{$application->created_at}}</span></p>
                            <p><b>{{__('Last updated')}}</b><span class="badge badge-primary">{{$application->updated_at}}</span></p>
                            <p><b>{{__('Applying for')}}</b> <span class="badge badge-primary">{{$vacancy->vacancyName}}</span></p>
                            <p class="mt-2"><b>{{__('Current Status')}}</b>
                                @switch($application->applicationStatus)

                                    @case('STAGE_SUBMITTED')
                                        <span class="badge badge-warning">{{__('Outstanding')}}</span>
                                        @break

                                    @case('STAGE_PEERAPPROVAL')
                                        <span class="badge badge-primary">{{__('Peer Approval')}}</span>
                                    @break

                                    @case('STAGE_INTERVIEW')
                                        <span class="badge badge-primary">{{__('Pending Interview')}}</span>
                                    @break

                                    @case('STAGE_INTERVIEW_SCHEDULED')
                                        <span class="badge badge-primary"><i class="fas fa-clock"></i> {{__('Interview Scheduled')}}</span>
                                    @break

                                    @case('APPROVED')
                                        <span class="badge badge-success"><i class="fa fa-check-double"></i> {{__('Approved')}}</span>
                                    @break

                                    @case('DENIED')
                                        <span class="badge badge-danger"><i class="fa fa-ban"></i> {{__('Denied')}}</span>
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

                                <div class="card-title">{{__('Decision & Moderation Tools')}}</div>

                            </div>

                            <div class="card-body text-center" style="white-space: nowrap">

                                <div class="row">


                                    <div class="col mr-5">
                                        <button type="button" class="btn btn-danger" onclick="$('#denyApplication').modal('show')" {{($application->applicationStatus == 'DENIED') ? 'disabled' : ''}}><i class="fas fa-arrow-left"></i> {{__('Decline application')}}</button>
                                    </div>

                                    <div class="col">
                                        <form method="POST" action="{{route('updateApplicationStatus', ['application' => $application->id, 'newStatus' => 'interview'])}}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success" {{($application->applicationStatus == 'DENIED') ? 'disabled' : ''}}><i class="fas fa-arrow-right" ></i> {{__('Move to next stage')}}</button>
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

                        <x-card id="appointmentCard" card-title="{{__('Schedule an Appointment')}}" footer-style="text-center">

                            <x-slot name="cardHeader">

                            </x-slot>

                            <form id="scheduleAppointment" action="{{route('scheduleAppointment', ['application' => $application->id])}}" method="POST">

                                @csrf

                                <label for="appointmentDescription">{{__('Appointment description')}}</label>
                                <input type="text" class="form-control" name="appointmentDescription">

                                <label for="appointmentDateTime">{{__('Appointment Date & Time')}}</label>
                                <input type="text" class="form-control" name="appointmentDateTime" id="appointmentDateTime">
                                <p class="text-muted text-sm">{{__('Click to choose a date')}}</p>

                                <label for="appointmentLocation">{{__('Appointment Location')}}</label>
                                <select class="custom-select" id="appointmentLocation" name="appointmentLocation">

                                    <option value="nil" disabled>{{__('Select your preferred platform')}}</option>
                                    <option value="ZOOM">{{ __('Zoom') }}</option>
                                    <option value="DISCORD">{{ __('Discord') }}</option>
                                    <option value="SKYPE">{{ __('Skype') }}</option>
                                    <option value="MEET">{{ __('Google Meet') }}</option>
                                    <option value="TEAMSPEAK">{{ __('Teamspeak') }}</option>

                                </select>
                                <p class="text-muted text-sm">{{__('Embedded in-house video conferencing coming soon, powered by Jitsi Meet')}}</p>
                            </form>

                            <x-slot name="cardFooter">
                                <button type="button" class="btn btn-warning text-center" onclick="document.getElementById('scheduleAppointment').submit()"><i class="fas fa-clock"></i> {{__('Schedule')}}</button>
                            </x-slot>

                        </x-card>

                    </div>

                </div>

            @endif

            @if ($application->applicationStatus == 'STAGE_INTERVIEW_SCHEDULED')

                <div class="row">

                    <div class="col">

                        <x-card id="scheduleInfo" card-title="{{__('Appointment Information')}}" footer-style="text-center">

                            <x-slot name="cardHeader"></x-slot>

                            <p class="text-muted">{{$application->appointment->appointmentDescription}}</p>

                            <p><b>{{__('Interview Scheduled for:')}}</b> <span class="badge badge-primary">{{$application->appointment->appointmentDate}}</span></p>
                            <p><b>{{__('Status')}}: </b> <span class="badge badge-primary">{{Str::ucfirst(Str::lower($application->appointment->appointmentStatus))}}</span></p>
                            <p><b>{{__('Platform')}}:</b> <span class="badge badge-primary">{{Str::ucfirst(Str::lower($application->appointment->appointmentLocation))}}</span></p>

                            <x-slot name="cardFooter">

                                @can('appointments.schedule.edit')
                                    <form style="white-space: nowrap;display:inline-block" class="footer-button" action="{{route('updateAppointment', ['application' => $application->id, 'status' => 'concluded'])}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i> {{__('Finish Meeting')}}</button>
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="$('#cancelAppointmentModal').modal('show')"><i class="far fa-calendar-times"></i> {{__('Cancel meeting')}}</button>
                                @endcan

                                @can('applications.vote')
                                    <button class="btn btn-warning mr-3 btn-sm" onclick="$('#notes').modal('show')"><i class="fas fa-clipboard"></i> {{__('View Meeting Notes')}}</button>
                                @endcan

                            </x-slot>

                        </x-card>

                    </div>

                </div>

            @endif

            @if ($application->applicationStatus == 'STAGE_PEERAPPROVAL' && Auth::user()->can('applications.vote'))

                <x-card id="peerApproval" card-title="{{__('Vote on this application')}}" footer-style="text-center">

                    <x-slot name="cardHeader"></x-slot>

                    <p class="text-muted">{{__("If you weren't present during this meeting, you can view the shared meeting notepad to help you make a decision.")}}</p>
                    <p class="text-muted">{{__('You may vote on as many applications as needed; However, you can only vote once per application.')}}</p>

                    <p class="text-muted">{{__('Votes carry no weight based on rank. This system has been designed with fairness and ease of use in mind.')}}</p>

                    <x-slot name="cardFooter">

                        @if($canVote)

                            <form class="d-inline-block" method="POST" action="{{route('voteApplication', ['application' => $application->id])}}">
                                @csrf
                                <input type="hidden" name="voteType" value="VOTE_APPROVE">
                                <button type="submit" class="btn btn-sm btn-warning">{{__('Vote: Approve Applicant')}}</button>
                            </form>
                            <form class="d-inline-block" method="POST" action="{{route('voteApplication', ['application' => $application->id])}}">
                                @csrf
                                <input type="hidden" name="voteType" value="VOTE_DENY">
                                <button type="submit" class="btn btn-sm btn-warning">{{__('Vote: Deny Applicant')}}</button>
                            </form>

                        @endif

                        <button type="button" class="btn btn-sm btn-warning {{($canVote) ? 'ml-5' : ''}}" onclick="$('#notes').modal('show')">{{__('Meeting notes')}}</button>
                    </x-slot>

                </x-card>

            @endif

            @can('applications.view.all')

                <div class="row">

                    <div class="col text-center">

                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{route('allApplications')}}'">{{__('View more Applications')}}</button>

                    </div>

                </div>

            @endcan

        </div>

    </div>

    @hasanyrole('reviewer|hiringManager|admin')
      @if (!Auth::user()->is($application->user))
        <div class="row mb-3 mt-2">

            <h3>{{__('Comments')}} ({{$comments->count()}})</h3>

        </div>

        <div class="row">

            <div class="col">

                @if ($comments->isEmpty())

                    <div class="alert alert-warning">
                        <i class="fas fa-question"></i> <b></b>


                        <p>{{__('There are no comments here! Comments are only visible to staff members. Be the first to share your input! Commenting may help with decision-making when time comes to vote for an application.')}}</p>


                    </div>
                @endif

            </div>

        </div>


                @if (!$comments->isEmpty())

                        @foreach($comments as $comment)
                          <div class="row mt-3 mb-3">
                            <div class="col-md-2">

                                <div class="text-center">
                                    @if($comment->user->profile->avatarPreference == 'gravatar')
                                        <img class="profile-user-img img-fluid img-circle" src="https://gravatar.com/avatar/{{md5($comment->user->email)}}" alt="{{ __('User profile picture') }}">
                                    @else
                                        <img class="profile-user-img img-fluid img-circle" src="https://crafatar.com/avatars/{{$comment->user->uuid}}" alt="{{ __('User profile picture') }}">
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
                    <img class="profile-user-img img-fluid img-circle" src="https://gravatar.com/avatar/{{md5(Auth::user()->email)}}" alt="{{__("User profile picture")}}">
                @else
                    <img class="profile-user-img img-fluid img-circle" src="https://crafatar.com/avatars/{{Auth::user()->uuid}}" alt="{{__("User profile picture")}}>
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
                            <p class="text-sm text-muted">{{__('Commenting as :usernameValue', ['usernameValue' => Auth::user()->name ])}}</p>
                        </div>


                        <div class="col text-right">

                            <p class="text-sm text-muted"><span id="charcount">0</span>/600 {{__(' max characters')}}</p>

                        </div>

                    </div>

                </div>

                <div class="card-footer text-right">

                    <button type="button" id="submitComment" class="btn btn-sm btn-secondary">{{__('Post')}}</button>

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
