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

            <div class="card">

                <div class="card-header">

                    <div class="card-title"><h4>Outstanding Applications</h4></div>

                </div>

                <div class="card-body">

                    <table class="table" style="white-space: nowrap">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Applicant Name</th>
                                <th>Status</th>
                                <th>Applied On</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>1</td>
                                <td>Jonathan Smith</td>
                                <td><span class="badge badge-info">Under Review</span></td>
                                <td>2020-04-20</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm"><i class="fas fa-clipboard-check"></i> Review</button>
                                    <button type="button" class="btn btn-warning btn-sm"><i class="fas fa-dumpster-fire"></i> Spam</button>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="card-footer text-center">

                    <button type="button" class="btn btn-success" onclick="window.location.href='{{route('peerReview')}}'">View Approval Queue</button>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Applications at a Glance</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;">
                    <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="appOverviewChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 456px;" width="456" height="250" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

        </div>

    </div>

@stop
