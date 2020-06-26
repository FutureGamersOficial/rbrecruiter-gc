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
                    <h3>{{$users->count()}}</h3>

                    <p>Active Staff Members</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-tie"></i>
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
                          <th>UUID</th>
                          <th>Rank</th>
                          <th>Status</th>
                          <th>Join Date</th>
                          <th>Actions</th>
                      </tr>
                      </thead>

                      <tbody>

                      @foreach($users as $user)

                        <tr>
                            <td>1</td>
                            <td>{{$user->name}}</td>
                            <td>{{UUID::toUsername($user->uuid)}}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-info badge-sm">{{$role->name}}</span>
                                @endforeach
                            </td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success mr-2" onclick="window.location.href='{{route('showSingleProfile', ['user' => $user->id])}}'"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-warning mr-2"><i class="fas fa-pencil-alt"></i></button>
                            </td>
                        </tr>

                      @endforeach
                      
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
