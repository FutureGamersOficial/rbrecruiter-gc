@extends('adminlte::page')

@section('title', 'Raspberry Network | Applications')

@section('content_header')

    <h4>My Account / Denied Applications</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="callout callout-danger">
                <h5>Info on denied applications</h5>

                <p>Please note that all applications listed on this page have been denied by the staff team / applications team.</p>
                <p>The system will only let you apply every thirty days. Your previous applications will be kept for your reference, but you can always delete them here.</p>
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
                            <th>Denial Date</th>
                            <th style="width: 40px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Jonathan Smith</td>
                            <td>2020-04-28</td>
                            <td>2020-04-30</td>
                            <td></td>
                            <td><span class="badge bg-danger">Denied</span></td>
                            <td>

                                <button type="button" class="btn btn-success btn-sm">View</button>
                                <button type="button" class="btn btn-danger btn-sm">Delete</button>

                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                    <button type="button" class="btn btn-default mr-2">Back</button>
                    <button type="button" class="btn btn-info mr-2">Approved Applications</button>
                    <button type="button" class="btn btn-info mr-2">Active Applications</button>

                </div>
            </div>

        </div>

    </div>

@stop
