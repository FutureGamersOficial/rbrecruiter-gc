@extends('breadcrumbs.auth.main')

@section('authpage')

  <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="/img/login.jpg" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="{{ config('adminlte.logo_img') }}" alt="logo" class="logo">{{ config('adminlte.logo') }}
              </div>
              <p class="login-card-description">{{__('messages.2fa_txt')}}</p>
              <form action="{{ route('verify2FA') }}" method="POST" id="verify">
                  @csrf
                  <div class="form-group">
                    <label for="name" class="sr-only">{{__('messages.2fa_sronly')}}</label>
                    <input type="text" name="otp" id="name" class="form-control" placeholder="{{__('messages.profile.2fa_send_code_s')}}">
                  </div>
                  <input name="register" id="register" class="btn btn-block login-btn mb-4" type="submit" value="{{__('messages.profile.2fa_send_code')}}">
                </form>
                <p class="login-card-footer-text">{{__('messages.2fa_lostcode')}} <a href="{{ route('logout') }}" class="text-reset">{{__('messages.2fa_cancel_login')}}</a></p>
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
