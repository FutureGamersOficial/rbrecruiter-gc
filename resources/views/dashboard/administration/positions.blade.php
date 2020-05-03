@extends('adminlte::page')

@section('title', 'Raspberry Network | Open Positions')

@section('content_header')

    <h4>Administration / Open Positions</h4>

@stop

@section('content')

    <div class="row">

        <div class="col-md-4 offset-md-4 text-center">

            <div class="card">

                <div class="card-body">

                    <button type="button" class="btn btn-primary">NEW POSITION</button>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card bg-gray-dark">

                <div class="card-header bg-indigo">
                    <div class="card-title"><h4 class="text-bold">Open Vacancies</h4></div>
                </div>

                <div class="card-body">

                    <table class="table table-active table-borderless">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Vacancy Name</th>
                                <th>Vacancy Description</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Total Applicants</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>Helper</td>
                                <td>Help manage the server</td>
                                <td>2020-04-03</td>
                                <td>2020-05-01</td>
                                <td>10</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Close Position</button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="card-footer">

                    <button type="button" class="btn btn-outline-primary">MANAGE APPLICATION FORMS</button>

                </div>

            </div>

        </div>

    </div>

@stop
