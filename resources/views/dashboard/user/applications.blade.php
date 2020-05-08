@extends('adminlte::page')

@section('title', 'Raspberry Network | Applications')

@section('content_header')

    <h4>My Account / Applications</h4>

@stop

@section('js')

    @if (session()->has('success'))

        <script>
            toastr.success("{{session('success')}}")
        </script>

    @elseif(session()->has('error'))

        <script>
            toastr.error("{{session('error')}}")
        </script>

    @endif

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="callout callout-warning">
                <h5>Application Process</h5>

                <p>Please allow up to three days for your application to be processed. Your application will be reviewed by every team member, and will move up in stages.</p>
                <p>If an interview is scheduled, you'll need to open your application here and confirm the time, date, and location assigned for you.</p>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Ongoing Applications</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0"> <!-- move to dedi css -->

                    <table class="table" style="white-space: nowrap">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Applicant</th>
                            <th>Application Date</th>
                            <th>Updated On</th>
                            <th style="width: 40px">Status</th>
                            <th style="width: 40px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Jonathan Smith</td>
                            <td>2020-04-28</td>
                            <td>2020-04-29</td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td>

                                <button type="button" class="btn btn-success btn-sm">View</button>
                                <button type="button" class="btn btn-danger btn-sm">Withdraw</button>

                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                    <button type="button" class="btn btn-default mr-2">Back</button>
                    <button type="button" class="btn btn-info mr-2">Approved Applications</button>
                    <button type="button" class="btn btn-info mr-2">Denied Applications</button>

                </div>
            </div>

        </div>

    </div>

@stop
