@extends('adminlte::page')

@section('title', 'Raspberry Network | Applications')

@section('content_header')

    <h4>My Account / Approved Applications</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="callout callout-success">
                <h5>Info on approved applications</h5>

                <p>Your approved applications will appear here. Approved applicants will be promoted and notified automatically by the system.</p>
                <p>Moderators will be able to review other applications.</p>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Denied Applications</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0"> <!-- move to dedi css -->

                    <table class="table" style="white-space: nowrap">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Applicant</th>
                            <th>Application Date</th>
                            <th>Approval Date</th>
                            <th>Status</th>
                            <th style="width: 40px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Jonathan Smith</td>
                            <td>2020-04-28</td>
                            <td>2020-04-30</td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td>

                                <button type="button" class="btn btn-success btn-sm">View</button>

                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                    <button type="button" class="btn btn-default mr-2">Back</button>
                    <button type="button" class="btn btn-info mr-2" onclick="window.location.href='{{route('userDeniedApps')}}'">Denied Applications</button>
                    <button type="button" class="btn btn-info mr-2" onclick="window.location.href='{{route('userPendingApps')}}'">Active Applications</button>

                </div>
            </div>

        </div>

    </div>

@stop
