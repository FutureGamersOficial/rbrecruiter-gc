@extends('adminlte::page')

@section('title', 'Raspberry Network | Registered Players')

@section('content_header')

    <h4>Administration / Registered Players</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>11</h3>

                    <p>Registered Players</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col">

            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>200</h3>

                    <p>Total Banned Players</p>
                </div>
                <div class="icon">
                    <i class="fa fa-ban"></i>
                </div>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-md-4 offset-md-4">

            <div class="card">

                <div class="card-header">
                    <div class="card-title"><h4><i class="fas fa-search"></i>Search Players</h4></div>
                </div>

                <div class="card-body">

                    <form name="search">

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Username or UUID, etc...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <div class="row mt-5">

        <div class="col">

            <div class="alert alert-warning">
                <p>Please note: This list only includes players registered in the team management portal. In a future release, all network players will be shown here.</p>
            </div>

        </div>

    </div>


    <div class="row">

        <div class="col">

          <div class="card bg-gray-dark">

              <div class="card-header bg-indigo">

                  <div class="card-title"><h4 class="text-bold">Player Listing</h4></div>

              </div>

              <div class="card-body">

                  <table class="table table-borderless table-active">

                      <thead>
                      <tr>
                          <th>#</th>
                          <th>IGN</th>
                          <th>UUID</th>
                          <th>Status</th>
                          <th>Registration Date</th>
                          <th>Actions</th>
                      </tr>
                      </thead>

                      <tbody>

                          <tr>
                              <td>1</td>
                              <td>Notch</td>
                              <td>069a79f4-44e9-4726-a5be-fca90e38aaf5</td>
                              <td><span class="badge badge-success">Active</span></td>
                              <td>2020-02-10</td>
                              <td>
                                  <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Record</button>
                              </td>
                          </tr>

                      </tbody>

                  </table>

              </div>

              <div class="card-footer">

                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route("staffMemberList")}}'">See Staff Members</button>

              </div>

          </div>

        </div>

    </div>

@stop
