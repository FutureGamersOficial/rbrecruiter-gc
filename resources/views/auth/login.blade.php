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
              </div>
              <p class="login-card-description">{{__('messages.signin_cta')}}</p>
              <form action="{{ route('login') }}" method="POST" id="loginForm">
                  @csrf
                  @if ($demoActive)
                      <div class="alert alert-warning">
                          <p class="font-weight-bold"></i>{{__('Warning')}}</p>
                          <p>{{ __('Do not use real credentials; The application is in demo mode.') }}</p>

                          <p class="font-weight-bold">{{ __('Demo accounts:') }}</p>
                          <ul>
                              <li>admin@example.com</li>
                              <li>staffmember@example.com</li>
                              <li>enduser@example.com</li>
                          </ul>
                          <p>{{ __('The password is ":password" for all accounts.', ['password' => 'password']) }}</p>

                      </div>
                  @endif

                  <div class="form-group">
                    <label for="email" class="sr-only">{{__('messages.contactlabel_email')}}</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">{{__('messages.password')}}</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                  </div>
                  <div class="form-group mb-4">
                    <label for="remember">{{__('messages.remember_me')}}</label>
                    <input type="checkbox" name="remember" id="remember" />
                  </div>
                  <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="{{__('messages.login')}}">
                </form>
                <a href="{{ route('password.request') }}" class="forgot-password-link">{{__('messages.forgot_pw')}}</a>
                <p class="login-card-footer-text">{{__('messages.no_acc')}} <a href="{{ route('register') }}" class="text-reset">{{__('messages.register_cta')}}</a></p>
                <nav class="login-card-footer-nav">
                  <a href="#!">{{__('messages.terms')}}</a>
                  <a href="#!">{{__('messages.ppolicy')}}</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
@stop
