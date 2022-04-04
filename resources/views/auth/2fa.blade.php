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
                <img src="{{ config('adminlte.logo_img') }}" alt="logo" class="logo">{{ config('adminlte.logo') }}
              </div>
              <p class="login-card-description">{{__('Multi-factor authentication is enabled for your account.')}}</p>
              <form action="{{ route('verify2FA') }}" method="POST" id="verify">
                  @csrf
                  <div class="form-group">
                    <label for="name" class="sr-only">{{__('Two-factor secret code (You can find this on Google Authenticator or the app you chose during setup)')}}</label>
                    <input type="text" name="otp" id="name" class="form-control" placeholder="{{__('2FA Code (ex. 41351)')}}">
                  </div>
                  <input name="register" id="register" class="btn btn-block login-btn mb-4" type="submit" value="{{__('Send 2FA Code')}}">
                </form>
                <p class="login-card-footer-text">{{__("Don't know the code?")}} <a href="{{ route('logout') }}" class="text-reset">{{__('Cancel sign in (sign out)')}}</a></p>
                <nav class="login-card-footer-nav">
                  <a href="{{ config('app.guidelines_url') }}">{{__('Community Guidelines')}}</a>
                  <a href="{{ config('app.privacy_url') }}">{{__('Privacy Policy')}}</a>
                    <a href="{{ config('app.terms_url') }}">{{__('Terms of Service')}}</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

@stop
