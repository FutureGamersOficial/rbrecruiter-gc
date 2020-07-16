@extends('adminlte::page')

@section('title', 'Raspberry Network | Profile')

@section('content_header')

    <h4>Application Management / Outstanding Applications</h4>

@stop

@section('js')

    <script type="text/javascript" src="/js/app.js"></script>

@stop


@section('content')

    <div class="row">

        <div class="col">
            <div class="callout callout-info">
                <p>Seeing no applications? Check with an Administrator to make sure that there are available open positions.</p>
                <p>Advertising on relevant forums made for this purpose is also a good idea.</p>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-header">

                    <div class="card-title"><h4>Outstanding Applications</h4></div>

                </div>

                <div class="card-body">

                    @if (!$applications->isEmpty())
                        <table class="table" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>Applicant Name</th>
                                <th>Status</th>
                                <th>Application Date</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>

                            </thead>

                            <tbody>

                            @foreach($applications as $application)

                                <tr>

                                    <td>{{$application->id}}</td>
                                    <td>{{$application->user->name}}</td>
                                    <td><span class="badge badge-warning">{{($application->applicationStatus == 'STAGE_SUBMITTED') ? 'Outstanding' : 'Unknown Status'}}</span></td>
                                    <td>{{$application->created_at}}</td>
                                    <td>{{$application->updated_at}}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="window.location.href='{{route('showUserApp', ['application' => $application->id])}}'"><i class="fas fa-clipboard-check"></i> Review</button>
                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>
                    @else

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i><b> There are no pending applications</b>
                            <p>It seems like no one new has applied yet. Checkout the interview and approval queues for applications that might have moved up the ladder by now.</p>
                        </div>

                    @endif

                </div>

                <div class="card-footer text-center">

                    <button type="button" class="btn btn-success" onclick="window.location.href='{{route('pendingInterview')}}'">View Interview Queue</button>

                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
