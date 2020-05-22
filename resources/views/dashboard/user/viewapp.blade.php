@extends('adminlte::page')

@section('title', 'Raspberry Network | Profile')

@section('content_header')

    <h4>Application Management / Viewing {{$application->user->name}}'s Application</h4>

@stop

@section('css')

    <link rel="stylesheet" href="/css/mixed.css">
    <link rel="stylesheet" href="/css/viewapplication.css">
    <!-- TODO: Move to Mix + Webpack  -->


@stop

@section('js')

    <script type="text/javascript" src="/js/app.js"></script>
    <x-global-errors></x-global-errors>

@stop

@section('content')

        <x-modal id="denyApplication" modal-label="denyApplicationLabel" modal-title="Please confirm" include-close-button="true">

            <p>Are you sure you want to deny this application? Please keep in mind that this user will only be allowed to apply 30 days after their first application.</p>
            <p class="text-muted">This action cannot be undone.</p>

            <x-slot name="modalFooter">

                <form id="updateApplication" action="{{route('updateApplicationStatus', ['id' => $application->id, 'newStatus' => 'deny'])}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Confirm: Deny Applicant</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </x-slot>

        </x-modal>


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

        <div class="col">

            <div class="row">

                <div class="col">

                    <div class="card bg-gray">

                        <div class="card-header bg-gradient-gray">
                            <div class="card-title">Contextual Information</div>
                        </div>

                        <div class="card-body">

                            <p><b>Applicant Name: </b> <span class="badge badge-primary">{{$application->user->name}}</span></p>
                            <p><b>Applicant IP Address:</b> <span class="badge badge-primary">{{$application->user->originalIP}}</span></p>
                            <p><b>Applied On:</b> <span class="badge badge-primary">{{$application->created_at}}</span></p>
                            <p><b>Last acted on:</b><span class="badge badge-primary">{{$application->updated_at}}</span></p>
                            <p><b>Applying for:</b> <span class="badge badge-primary">{{$vacancy->vacancyName}}</span></p>
                            <p class="mt-2"><b>Current Status:</b>
                                @switch($application->applicationStatus)

                                    @case('STAGE_SUBMITTED')
                                        <span class="badge badge-warning">Outstanding</span>
                                        @break

                                    @case('STAGE_PEERAPPROVAL')
                                        <span class="badge badge-primary">Pending Peer Approval</span>
                                    @break

                                    @case('STAGE_INTERVIEW')
                                        <span class="badge badge-primary">Pending Interview</span>
                                    @break

                                    @case('STAGE_INTERVIEW_SCHEDULED')
                                        <span class="badge badge-primary"><i class="fas fa-clock"></i> Interview Scheduled</span>
                                    @break

                                    @case('APPROVED')
                                        <span class="badge badge-success"><i class="fa fa-check-double"></i> Approved</span>
                                    @break

                                    @case('DENIED')
                                        <span class="badge badge-danger"><i class="fa fa-ban"></i> Denied</span>
                                    @break



                                @endswitch
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <div class="row">

                <div class="col">

                    @if ($application->applicationStatus == 'STAGE_SUBMITTED')

                        <div class="card bg-gray">
                            <div class="card-header bg-gradient-gray">

                                <div class="card-title">Decision & Moderation Tools</div>

                            </div>

                            <div class="card-body text-center" style="white-space: nowrap">

                                <div class="row">


                                    <div class="col mr-5">
                                        <button type="button" class="btn btn-danger" onclick="$('#denyApplication').modal('show')" {{($application->applicationStatus == 'DENIED') ? 'disabled' : ''}}><i class="fas fa-arrow-left"></i> Deny Applicant</button>
                                    </div>

                                    <div class="col">
                                        <form method="POST" action="{{route('updateApplicationStatus', ['id' => $application->id, 'newStatus' => 'interview'])}}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success" {{($application->applicationStatus == 'DENIED') ? 'disabled' : ''}}><i class="fas fa-arrow-right" ></i> Move to next stage</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                    @endif


                </div>

            </div>

            @if ($application->applicationStatus == 'STAGE_INTERVIEW')

                <div class="row">

                    <div class="col">

                        <x-card id="appointmentCard" card-title="Schedule An Interview" footer-style="text-center">

                            <x-slot name="cardHeader">

                            </x-slot>

                            <form id="scheduleAppointment" action="{{route('scheduleAppointment', ['applicationID' => $application->id])}}" method="POST">

                                @csrf

                                <label for="appointmentDescription">Appointment Description</label>
                                <input type="text" class="form-control" name="appointmentDescription">

                                <label for="appointmentDateTime">Interview date & time</label>
                                <input type="text" class="form-control" name="appointmentDateTime" id="appointmentDateTime">
                                <p class="text-muted text-sm">Click to choose a date</p>

                                <label for="appointmentLocation">Appointment Location</label>
                                <select class="custom-select" id="appointmentLocation" name="appointmentLocation">

                                    <option value="nil" disabled>Select your preferred platform</option>
                                    <option value="ZOOM">Zoom</option>
                                    <option value="DISCORD">Discord</option>
                                    <option value="SKYPE">Skype</option>
                                    <option value="MEET">Google Meet</option>
                                    <option value="TEAMSPEAK">Teamspeak</option>

                                </select>
                                <p class="text-muted text-sm">Embedded in-house video conferencing coming soon, powered by Jitsi Meet</p>
                            </form>

                            <x-slot name="cardFooter">
                                <button type="button" class="btn btn-warning text-center" onclick="document.getElementById('scheduleAppointment').submit()"><i class="fas fa-clock"></i> Schedule</button>
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

                            <p><b>Interview scheduled for:</b> <span class="badge badge-primary">{{$application->appointment->appointmentDate}}</span></p>
                            <p><b>Status: </b> <span class="badge badge-primary">{{Str::ucfirst(Str::lower($application->appointment->appointmentStatus))}}</span></p>
                            <p><b>Platform:</b> <span class="badge badge-primary">{{Str::ucfirst(Str::lower($application->appointment->appointmentLocation))}}</span></p>

                            <x-slot name="cardFooter">

                                <form class="footer-button" action="{{route('updateAppointment', ['applicationID' => $application->id, 'status' => 'concluded'])}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Finish Meeting</button>
                                </form>
                                <button class="btn btn-warning mr-3">View Meeting Notes</button>

                                <button class="btn btn-danger mr-3">Cancel Interview</button>
                            </x-slot>

                        </x-card>

                    </div>

                </div>

            @endif

            @if ($application->applicationStatus = 'STAGE_PEERAPPROVAL')

                <x-card id="peerApproval" card-title="Vote on this Application" footer-style="text-center">

                    <x-slot name="cardHeader"></x-slot>

                    <p class="text-muted">If you weren't present during this meeting, you can view the shared meeting notepad to help you make a decision.</p>
                    <p class="text-muted">You may vote on as many applications as needed; However, you can only vote once per application.</p>

                    <p class="text-muted">Votes carry no weight based on rank. This system has been designed with fairness and ease of use in mind.</p>

                    <x-slot name="cardFooter">

                        <button type="button" class="btn btn-sm btn-warning">Vote: Approve Applicant</button>
                        <button type="button" class="btn btn-sm btn-warning">Vote: Deny Applicant</button>

                        <button type="button" class="btn btn-sm btn-warning ml-5">Meeting Notes</button>
                    </x-slot>

                </x-card>

            @endif

            <div class="row">

                <div class="col text-center">

                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{route('staffPendingApps')}}'">View more Applications</button>

                </div>

            </div>

        </div>

    </div>


@endsection
