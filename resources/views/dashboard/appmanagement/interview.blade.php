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
                    <h3>3</h3>
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
                    <h3>4</h3>
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

                            <tr>

                                <td>1</td>
                                <td>Jonathan Smith</td>
                                <td><span class="badge badge-warning">Awaiting Interview</span></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View</button>
                                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-clock"></i> Schedule</button>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card">

                <div class="card-header">

                    <div class="card-title"><h3>My Upcoming Interviews</h3></div>

                </div>

                <div class="card-body">

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

                            <tr>
                                <td>1</td>
                                <td>April Smith</td>
                                <td><span class="badge badge-success"><i class="fa fa-check"></i> Scheduled</span></td>
                                <td>2020-05-04 12:20</td>
                                <td>Discord</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Details</button>
                                    <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-ban"></i> Cancel Interview</button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@stop
