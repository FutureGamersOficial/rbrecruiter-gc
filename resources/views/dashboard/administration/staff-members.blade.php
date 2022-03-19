@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Staff members'))

@section('content_header')

    <h4>{{__('Administration')}} / {{__('Staff members')}}</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$users->count()}}</h3>

                    <p>{{__('Active Staff Members')}}</p>
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

                  <div class="card-title"><h4 class="text-bold">{{__('Member listing')}}</h4></div>

              </div>

              <div class="card-body">

                  <table class="table table-borderless table-active">

                      <thead>
                      <tr>
                          <th>#</th>
                          <th>{{__('Full name')}}</th>
                          <th>{{__('Rank')}}</th>
                          <th>{{__('Email')}}</th>
                          <th>{{__('Status')}}</th>
                          <th>{{__('Join date')}}</th>
                          <th>{{__('Actions')}}</th>
                      </tr>
                      </thead>

                      <tbody>

                      @foreach($users as $user)

                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-info badge-sm">{{$role->name}}</span>
                                @endforeach
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <x-account-status user-id="{{ $user->id }}"></x-account-status>
                            </td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success mr-2" onclick="window.location.href='{{route('showSingleProfile', ['user' => $user->id])}}'"><i class="fa fa-eye"></i></button>
                            </td>
                        </tr>

                      @endforeach

                      </tbody>

                  </table>

              </div>

              <div class="card-footer">

                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route("registeredPlayerList")}}'">{{__('View Registered Users (Applicant Pool)')}}</button>

              </div>

          </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
