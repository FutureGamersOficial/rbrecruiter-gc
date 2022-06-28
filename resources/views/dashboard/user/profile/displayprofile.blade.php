@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __(":userNameValue's profile", ['userNameValue' => $profile->user->name]))

@section('content_header')

    <h4>{{__('Users')}} / {{__('Profile')}} / {{ $profile->user->name }}</h4>

@stop

@section('js')

    <script src="/js/app.js"></script>
    <x-global-errors></x-global-errors>

@stop


@section('content')

  @if (is_array($suspensionInfo))

      <div class="alert alert-danger">

          <span><i class="fa fa-ban"></i> <b>{{__('This account has been suspended :suspensionTypeValue', ['suspensionTypeValue' => ($suspensionInfo['isPermanent']) ? __('permanently.') : __('until :date.', ['date' => $suspensionInfo['bannedUntil']])]) }}</b></span>

          <p>{{__('This user has been suspended.')}}</p>

          <p>
              <i class="fas fa-chevron-right"></i> <b>{{$suspensionInfo['reason']}}</b>
          </p>

      </div>

  @endif

    <div class="row mb-3">

        <div class="col">

            <div class="text-center">
                @if($profile->avatarPreference == 'gravatar')
                    <img class="profile-user-img img-fluid img-circle" src="https://gravatar.com/avatar/{{md5($profile->user->email)}}" alt="{{ __('User profile picture') }}">
                @else
                    <img class="profile-user-img img-fluid img-circle" src="https://crafatar.com/avatars/{{$profile->user->uuid}}" alt="{{ __('User profile picture') }}">
                @endif
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-4 offset-md-4">

            <div class="card">

                <div class="card-body text-center">

                    @if ($profile->user->isBanned())
                        <del><h3>{{$profile->user->name}}</h3></del>
                    @else
                        <h3>{{$profile->user->name}}</h3>
                    @endif

                    <p class="text-muted">{{$profile->profileShortBio}}</p>
                    <p class="text-muted">{{__('Member since :date', ['date' => $since])}}</p>

                    @if ($profile->user->is(Auth::user()))
                        <button type="button" class="btn btn-sm btn-warning" onclick="window.location.href='{{route('showProfileSettings')}}'"><i class="fas fa-pencil-alt"></i></button>
                    @endif

                </div>

                <div class="card-footer text-center">

                    @foreach ($profile->user->roles as $role)

                        <span class="badge badge-success mr-2">{{ucfirst($role->name)}}</span>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    <div class="row buttonBar">

        <div class="col-md-4 offset-md-4">

            <div class="card" style="border-radius: 50px">

                <div class="card-body text-center">

                    <a href="https://github.com/{{$github}}" class="pr-2 pl-2"><i class="fab fa-github fa-2x"></i></a>
                    <a href="#" onclick="toastr.info('{{__("User's Discord Tag: :discordTag", ['discordTag' => $discord])}}')" class="pr-2 pl-2"><i class="fab fa-discord fa-2x"></i></a>
                    <a href="https://twitter.com/{{$twitter}}" class="pr-2 pl-2"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="https://instagram.com/{{$insta}}" class="pr-2 pl-2"><i class="fab fa-instagram fa-2x"></i></a>


                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">

            <div class="card-header">
                <h4>{{__('About')}}</h4>
            </div>

            <div class="card-body">

                {{$profile->profileAboutMe}}

            </div>

        </div>

        </div>


    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
