@extends('adminlte::page')

@section('title', 'Raspberry Network | Registered Players')

@section('content_header')

    <h4>Administration / Registered Players</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('content')

    <div class="row">

        <div class="col">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$users->count()}}</h3>

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
                    <h3>{{$bannedUserCount}}</h3>

                    <p>Total Banned Players</p>
                </div>
                <div class="icon">
                    <i class="fa fa-ban"></i>
                </div>
            </div>

        </div>
    </div>
I

    <div class="row">

        <div class="col-md-4 offset-md-4">

            <div class="card">

                <div class="card-header">
                    <div class="card-title"><h4><i class="fas fa-search"></i>Search Players</h4></div>
                </div>

                <div class="card-body">

                    <form name="search" method="POST" action="{{route('searchRegisteredPLayerList')}}">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="searchTerm" class="form-control" placeholder="Username/email search">
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
                @if (!$users->isEmpty())
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

                          @foreach($users as $user)
                            
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{UUID::toUsername($user->uuid)}}</td>
                                <td>{{$user->uuid}}</td>
                                <td>
                                    @if ($user->isBanned())
                                        <span class="badge badge-danger"><i class="fa fa-ban"></i> Banned</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                  <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='{{route('showSingleProfile', ['user' => $user->id])}}'"><i class="fa fa-eye"></i></button>
                              </td>
                            </tr>

                          @endforeach

                      </tbody>

                  </table>
                @else
                    <div class="alert alert-secondary">
                    
                        <i class="fas fa-question"></i><span> There are no registered players!</span>
                        <p>
                            Registered players are those without a staff role in the team management application.
                            There may be other users registered in the platform, but they won't be displayed here.
                        </p>

                    </div>
                @endif
              </div>

              <div class="card-footer">

                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route("staffMemberList")}}'">See Staff Members</button>

              </div>

          </div>

        </div>

    </div>

@stop
