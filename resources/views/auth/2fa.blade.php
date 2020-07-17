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
              <p class="login-card-description">Two-factor Authentication</p>
              <form action="{{ route('verify2FA') }}" method="POST" id="verify">
                  @csrf
                  <div class="form-group">
                    <label for="name" class="sr-only">Two-factor secret code (You can find this on Google Authenticator)</label>
                    <input type="text" name="otp" id="name" class="form-control" placeholder="2FA Code (e.g. 543324)">
                  </div>
                  <input name="register" id="register" class="btn btn-block login-btn mb-4" type="submit" value="Send 2FA Code">
                </form>
                <p class="login-card-footer-text">Don't know the code? <a href="{{ route('logout') }}" class="text-reset">Cancel login (logout)</a></p>
                <nav class="login-card-footer-nav">
                  <a href="#!">Terms of use</a>
                  <a href="#!">Privacy policy</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

@stop
