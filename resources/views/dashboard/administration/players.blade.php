@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Registered users'))

@section('content_header')

    <h4>{{__('messages.adm')}} / {{__('Users')}}</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('content')

    <div class="row">

        <div class="col">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $numUsers }}</h3>

                    <p>{{__('Registered users')}}</p>
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

                    <p>{{__('Suspended users')}}</p>
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
                    <div class="card-title"><h4><i class="fas fa-search"></i>{{__('Search users')}}</h4></div>
                </div>

                <div class="card-body">

                    <form name="search" method="POST" action="{{route('searchRegisteredPLayerList')}}">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="searchTerm" class="form-control" placeholder="{{__('messages.players.f_p_search')}}">
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

                  <div class="card-title"><h4 class="text-bold">{{__('Registered users')}}</h4></div>

              </div>

              <div class="card-body">
                @if (!$users->isEmpty())
                  <table class="table table-borderless table-active">

                      <thead>
                      <tr>
                          <th>#</th>
                          <th>{{__('Name')}}</th>
                          <th>{{__('messages.contactlabel_email')}}</th>
                          <th>{{__('messages.reusable.status')}}</th>
                          <th>{{__('messages.players.reg_date')}}</th>
                          <th>{{__('messages.reusable.actions')}}</th>
                      </tr>
                      </thead>

                      <tbody>

                          @foreach($users as $user)

                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <x-account-status user-id="{{ $user->id }}"></x-account-status>
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

                        <i class="fas fa-question"></i><span> {{__('messages.players.no_reg')}}</span>
                        <p>
                            {{__('messages.players.no_reg_exp')}}
                        </p>

                    </div>
                @endif
              </div>

              <div class="card-footer">

                  {{ $users->links() }}

              </div>

          </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
