@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.staff.members'))

@section('content_header')

    <h4>{{__('messages.adm')}} / {{__('messages.staff.members')}}</h4>

@stop

@section('content')

    <div class="row">

        <div class="col">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$users->count()}}</h3>

                    <p>{{__('messages.staff.active_sm')}}</p>
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

                  <div class="card-title"><h4 class="text-bold">{{__('messages.staff.m_listing')}}</h4></div>

              </div>

              <div class="card-body">

                  <table class="table table-borderless table-active">

                      <thead>
                      <tr>
                          <th>#</th>
                          <th>{{__('messages.staff.f_name')}}</th>
                          <th>{{__('messages.staff.rank')}}</th>
                          <th>{{__('messages.contactlabel_email')}}</th>
                          <th>{{__('messages.reusable.status')}}</th>
                          <th>{{__('messages.reusable.join_date')}}</th>
                          <th>{{__('messages.reusable.actions')}}</th>
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

                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route("registeredPlayerList")}}'">{{__('messages.players.reg_players_staff')}}</button>

              </div>

          </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
