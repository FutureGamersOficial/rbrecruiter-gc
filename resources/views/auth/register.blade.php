@extends('breadcrumbs.auth.main')

@section('authpage')

  <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="{{ asset(config('customization.authbanner')) }}" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="{{ config('adminlte.logo_img') }}" alt="logo" class="logo rounded mr-2">{{ config('adminlte.logo') }}
              </div> <!-- main content start -->
              <p class="login-card-description">{{__('Sign up for an account')}}</p>

              @if(\App\Facades\Options::getOption('pw_security_policy') !== 'off')

                  <div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <p><b>{{__('Basic password security')}}</b></p>
                    <p>{{__("For your security, we implement strict password policies. It's also advisable to let your password manager or browser generate and save passwords for you (if it's a private device).")}}</p>

                    <p>{{__('Passwords must be a combination of:')}} </p>
                    <ul>
                      @switch(\App\Facades\Options::getOption('pw_security_policy'))

                        @case('low')
                          <li>{{ __('A minimum of 10 characters') }}</li>
                          @break

                        @case('medium')
                          <li>{{ __('A minimum of 12 characters;') }}</li>
                          <li>{{ __('At least one special character;') }}</li>
                          <li>{{ __('Lower case and upper case characters') }}</li>
                          @break

                        @case('high')
                          <li>{{ __('A minimum of 20 characters;') }}</li>
                          <li>{{ __('At least one special character;') }}</li>
                          <li>{{ __('Lower case and upper case characters') }}</li>
                          <li>{{ __('At least one numerical character') }}</li>
                          @break

                      @endswitch
                    </ul>
                  </div>

              @endif

                @if($demoActive)
                    <div class="alert alert-warning">
                        <p class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i>{{ __('Warning') }}</p>
                        <p>{{ __('Do not use real credentials here. The application is in demo mode. Additionally, the database is wiped every six hours.') }}</p>

                        <p>{{ __("Also note: If a game license is required to sign up, you may find valid MC usernames at NameMC. No special validation is performed other than contacting Mojang's authentication servers to verify the username's existence, therefore, you can use any username for testing purposes.") }}</p>
                    </div>
                @endif

              <form action="{{ route('register') }}" method="POST" id="registerForm">
                  @csrf
                  <div class="form-group">
                    <label for="name" class="sr-only">{{__('Name')}}</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="{{__('Name')}}">
                  </div>
                  <div class="form-group mb-4">
                    <label for="email" class="sr-only">{{__('Email address')}}</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="{{__('Email address')}}">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">{{__('Password')}}</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="{{__('Password')}}">
                  </div>
                  <div class="form-group mb-4">
                    <label for="passwordc" class="sr-only">{{__('Confirm Password')}}</label>
                    <input type="password" id="passwordc" name="password_confirmation" class="form-control" placeholder="{{__('Confirm Password')}}" />
                  </div>


                  @if(\App\Facades\Options::getOption('requireGameLicense') && \App\Facades\Options::getOption('currentGame') == 'MINECRAFT')
                      <div class="form-group mt-5">
                        <label for="mcusername" class="sr-only">{{__('Minecraft Username (Premium)')}}</label>
                        <input type="text" name="uuid" class="form-control" id="mcusername" placeholder="{{__('Minecraft Username (Premium)')}}" />
                      </div>
                  @endif

                  <input name="register" id="register" class="btn btn-block login-btn mb-4" type="submit" value="{{__('Sign up')}}">
                </form>
                <p class="login-card-footer-text">{{__('Have an account with us?')}} <a href="{{ route('login') }}" class="text-reset">{{__('Sign in here')}}</a></p>
                <nav class="login-card-footer-nav">
                  <a href="#!">{{__('Terms of Service')}}</a>
                  <a href="#!">{{__('Privacy Policy')}}</a>
                    <a href="#!">{{__('Community Guidelines')}}</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

@stop
