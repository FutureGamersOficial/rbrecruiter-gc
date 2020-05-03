@extends('adminlte::page')

@section('title', 'Raspberry Network | Staff Members')

@section('content_header')

    <h4>Administration / Staff Members</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>11</h3>

                    <p>Active Staff Members</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-tie"></i>
                </div>
            </div>
        </div>

        <div class="col">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>2</h3>

                    <p>Former Staff Members</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>

        </div>

        <div class="col">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>1</h3>

                    <p>Terminated Staff Member(s)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-alt-slash"></i>
                </div>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-md-4 offset-md-4">

            <div class="card">

                <div class="card-header">
                    <div class="card-title"><h4><i class="fas fa-search"></i>Search Active Members</h4></div>
                </div>

                <div class="card-body">

                    <form name="search">

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for names, email addresses, etc...">
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


    <div class="row">

        <div class="col">

          <div class="card bg-gray-dark">

              <div class="card-header bg-indigo">

                  <div class="card-title"><h4 class="text-bold">Member Listing</h4></div>

              </div>

              <div class="card-body">

                  <table class="table table-borderless table-active">

                      <thead>
                      <tr>
                          <th>#</th>
                          <th>Full Name</th>
                          <th>IGN</th>
                          <th>Rank</th>
                          <th>Status</th>
                          <th>Join Date</th>
                          <th>Actions</th>
                      </tr>
                      </thead>

                      <tbody>

                      <tr>
                          <td>1</td>
                          <td>Monica Smith</td>
                          <td>mssmith223</td>
                          <td><span class="badge badge-success">Moderator</span></td>
                          <td><span class="badge badge-success">Active</span></td>
                          <td>2020-02-10</td>
                          <td>
                              <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Staff Record</button>
                          </td>
                      </tr>
                      <tr>
                          <td>2</td>
                          <td>Zak Unknown</td>
                          <td>Skeppy</td>
                          <td><span class="badge badge-info">Helper</span></td>
                          <td><span class="badge badge-success">Active</span></td>
                          <td>2020-02-10</td>
                          <td>
                              <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Staff Record</button>
                          </td>
                      </tr>
                      <tr>
                          <td>3</td>
                          <td>John Doe</td>
                          <td>kjj192</td>
                          <td><span class="badge badge-danger">Admin</span></td>
                          <td><span class="badge badge-success">Active</span></td>
                          <td>2020-02-10</td>
                          <td>
                              <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Staff Record</button>
                          </td>
                      </tr>
                      <tr>
                          <td>4</td>
                          <td>Angela Smith</td>
                          <td>kkrapsody1221</td>
                          <td><span class="badge badge-success">Moderator</span></td>
                          <td><span class="badge badge-success">Active</span></td>
                          <td>2020-02-10</td>
                          <td>
                              <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Staff Record</button>
                          </td>
                      </tr>

                      </tbody>

                  </table>

              </div>

              <div class="card-footer">

                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route("registeredPlayerList")}}'">See Registered Players (Applicant Pool)</button>

              </div>

          </div>

        </div>

    </div>

@stop
