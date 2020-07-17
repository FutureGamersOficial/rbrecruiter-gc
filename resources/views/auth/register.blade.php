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
              <p class="login-card-description">Register a new account</p>
              <div class="alert alert-warning alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <p><b>Basic password security</b></p>
                  <p>For your security, we implement strict password policies. It's also advisable to let your password manager or browser generate and save passwords for you (if it's a private device).</p>

                  <p>Passwords must be a combination of: </p>
                  <ul>
                    <li>
                      A minimum of 6 characters;
                    </li>
                    <li>
                      At least 3 uppercase characters;
                    </li>
                    <li>
                      At least 3 numbers;
                    </li>
                    <li>
                      Any number of special characters.
                    </li>
                  </ul>
              </div>
              <form action="{{ route('register') }}" method="POST" id="registerForm">
                  @csrf
                  <div class="form-group">
                    <label for="name" class="sr-only">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name (e.g. John Smith)">
                  </div>
                  <div class="form-group mb-4">
                    <label for="email" class="sr-only">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                  </div>
                  <div class="form-group mb-4">
                    <label for="passwordc" class="sr-only">Confirm password</label>
                    <input type="password" id="passwordc" name="password_confirmation" class="form-control" placeholder="Confirm password" />
                  </div>

                  <div class="form-group mt-5">
                    <label for="mcusername" class="sr-only">Minecraft Username (Premium)</label>
                    <input type="text" name="uuid" class="form-control" id="mcusername" placeholder="Premium Minecraft Username (e.g. Notch)" />
                  </div>
                  <input name="register" id="register" class="btn btn-block login-btn mb-4" type="submit" value="Register">
                </form>
                <p class="login-card-footer-text">Have an account with us? <a href="{{ route('login') }}" class="text-reset">Login here</a></p>
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
