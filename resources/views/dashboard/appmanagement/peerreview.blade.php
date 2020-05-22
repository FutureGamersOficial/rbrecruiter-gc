@extends('adminlte::page')

@section('title', 'Raspberry Network | Applications')

@section('content_header')

    <h4>Application Management / Peer Review</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="callout callout-info">

                <h4>Voting Reminder</h4>

                <p>Applications which gain more than 50% of positive votes are automatically approved after one day.</p>
                <p>Conversely, applications that do not reach this number are automatically denied.</p>

                <p>Please note that the vote system can be overriden.</p>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-header">
                    <div class="card-title"><h3>Vote Backlog</h3></div>
                </div>

                <div class="card-body">

                    @if(!$applications->isEmpty())
                        <table class="table" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>Applicant Name</th>
                                <th>Last Acted On</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>

                            </thead>

                            <tbody>


                            @foreach($applications as $application)

                                <td>{{$application->id}}</td>
                                <td>{{$application->user->name}}</td>
                                <td>{{$application->created_at}}</td>
                                <td><span class="badge badge-warning">{{($application->applicationStatus == 'STAGE_PEERAPPROVAL') ? 'Peer Review' : 'Unknown'}}</span></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" onclick="window.location.href='{{route('showUserApp', ['id' => $application->id])}}'"><i class="far fa-clipboard"></i> Review</button>
                                    <button type="button" class="btn btn-success btn-sm"><i class="fas fa-user-check"></i> Vote: Approve</button>
                                    <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-user-times"></i> Vote: Deny</button>
                                </td>

                            @endforeach

                            </tbody>

                        </table>
                    @else
                        <x-alert alert-type="warning">
                            <p class="text-bold"><i class="fa fa-exclamation-triangle"></i> There are no applications pending review</p>

                            Check the other queues for any applications! Applications will be shown here as soon as their interview is completed.
                            You'll be able to view meeting notes and vote based on your observations.
                        </x-alert>
                    @endif

                </div>

            </div>

        </div>

    </div>

@stop
