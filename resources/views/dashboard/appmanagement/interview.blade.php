@extends('adminlte::page')

@section('title', 'Raspberry Network | Applications')

@section('content_header')

    <h4>Application Management / Pending Interviews</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$applications->count()}}</h3>
                    <p>Pending Interviews</p>
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
                    <p>Finished Interviews</p>
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
                   <div class="card-title"><h3>Schedule Interviews</h3></div>
               </div>

                <div class="card-body">

                    @if (!$applications->isEmpty())

                        <table class="table" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>Interviewee</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>

                            </thead>

                            <tbody>

                            @foreach($applications as $application)

                                <tr>
                                    <td>{{$application->id}}</td>
                                    <td>{{$application->user->name}}</td>
                                    <td><span class="badge-warning badge">{{($application->applicationStatus == 'STAGE_INTERVIEW') ? 'Pending Interview' : 'Unknown Status'}}</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='{{route('showUserApp', ['application' => $application->id])}}'"><i class="fa fa-eye"></i> View</button>
                                        <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-clock"></i> Schedule</button>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="alert alert-danger">

                            <b><i class="fa fa-exclamation-triangle"></i> No Applications Pending Interview</b>
                            <p>There are no applications that have been moved up to the Interview stage. Please check the outstanding queue.</p>
                        </div>

                    @endif

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card">

                <div class="card-header">

                    <div class="card-title"><h3>My Upcoming Interviews</h3></div>

                </div>

                <div class="card-body">

                    @if (!$upcomingApplications->isEmpty())
                        <table class="table" style="white-space: nowrap">

                            <thead>

                            <tr>

                                <th>#</th>
                                <th>Interviewee</th>
                                <th>Status</th>
                                <th>Time & Date</th>
                                <th>Location</th>
                                <th>Actions</th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach($upcomingApplications as $upcomingApp)

                                <tr>
                                    <td>{{$upcomingApp->id}}</td>
                                    <td>{{$upcomingApp->user->name}}</td>
                                    @if (is_null($upcomingApp->appointment))
                                        <td><span class="badge badge-warning"><i class="fa fa-question-circle"></i>Pending Schedule</span></td>
                                        <td>None yet</td>
                                        <td><span class="badge badge-warning"><i class="fa fa-question-circle"></i>Pending Schedule</span></td>
                                    @else
                                        <td><span class="badge badge-success"><i class="fa fa-check"></i> {{ucfirst(strtolower($upcomingApp->appointment->appointmentStatus))}}</span></td>
                                        <td>{{$upcomingApp->appointment->appointmentDate}}</td>
                                        <td><span class="badge badge-success"><i class="fa fa-check"></i> {{ucfirst(strtolower($upcomingApp->appointment->appointmentLocation))}}</span></td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='{{route('showUserApp', ['application' => $upcomingApp->id])}}'"><i class="fa fa-eye"></i> View Details</button>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <x-alert alert-type="danger">
                            <p><i class="fa fa-exclamation-triangle"></i><b>There are no upcoming interviews</b></p>

                            Please check other queues down in the application process. Applicants here may have already been interviewed.
                        </x-alert>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="row mr-5">

        <div class="col text-center">

            <button type="button" class="btn btn-success mr-3" onclick="window.location.href='{{route('staffPendingApps')}}'">View Outstanding Queue</button>
            <button type="button" class="btn btn-success mr-3" onclick="window.location.href='{{route('peerReview')}}'">View Approval Queue</button>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
