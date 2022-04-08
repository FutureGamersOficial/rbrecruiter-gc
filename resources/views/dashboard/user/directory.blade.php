@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('User Directory'))

@section('content_header')

    <h4>{{__('Users')}} / {{__('Directory')}}</h4>

@stop

@section('js')
    <script src="/js/app.js"></script>
    <x-global-errors></x-global-errors>
@stop

@section('css')

  <link rel="stylesheet" href="/css/directory.css" />

@stop


@section('content')

  @if (Auth::user()->can('profiles.view.others'))


      <div class="row">

        @foreach ($users as $user)
              @if (!is_null($user->profile))
                  <div class="col-md-4">
                      <div class="card card-widget widget-user">
                          <div class="widget-user-header bg-secondary">
                              <h3 class="widget-user-username">{{ $user->name }}</h3>
                              <h5 class="widget-user-desc">{{ $user->profile->profileShortBio }}</h5>
                          </div>

                          <div class="widget-user-image">
                              @if($user->profile->avatarPreference == 'gravatar')
                                  <img class="profile-user-img elevation-2 img-fluid img-circle" src="https://gravatar.com/avatar/{{md5($user->email)}}" alt="{{ __('User profile picture') }}">
                              @else
                                  <img class="profile-user-img elevation-2 img-fluid img-circle" src="https://crafatar.com/avatars/{{$user->uuid}}" alt="{{ __('User profile picture') }}">
                              @endif
                          </div>
                          <div class="card-footer text-center">

                              @if (Auth::user()->is($user))

                                  <div class="user-indicator mb-2">

                                      <span class="badge badge-success">{{__("It's you!")}}</span>

                                  </div>

                              @endif

                              <div class="roles mb-2">

                                  @foreach ($user->roles as $role)

                                      <span class="badge badge-secondary mr-2">{{ucfirst($role->name)}}</span>

                                  @endforeach

                              </div>

                              <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('showSingleProfile', ['user' => $user->id]) }}'"><i class="fa fa-eye"></i> {{__('Profile')}}</button>

                          </div>
                      </div>
                      <!-- /.widget-user -->
                  </div>
              @endif
        @endforeach

      </div>

      <div clsas="row mt-4">

        <div class="col">

            <div class="card">

                <div class="card-body text-center">

                    <div class="links">
                      {{ $users->links() }}
                    </div>

                </div>

            </div>

        </div>

      </div>

  @else
      <div class="alert alert-danger">

        <p>
          {{__("We're sorry, but you do not have permission to access this web page.")}}
        </p>

      </div>
  @endif

@stop
@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
