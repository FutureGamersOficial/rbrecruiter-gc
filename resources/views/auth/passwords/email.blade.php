@extends('breadcrumbs.auth.main')

@section('authpage')

    <div class="container">
        <div class="card login-card">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <img src="{{ asset(config('customization.authbanner')) }}" alt="reset" class="login-card-img">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <div class="brand-wrapper">
                            <img src="{{ config('adminlte.logo_img') }}" alt="logo" class="logo rounded mr-2">{{ config('adminlte.logo') }}
                        </div>
                        <p class="login-card-description">{{__('Recover your account')}}</p>
                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('password.email') }}" method="POST" id="loginForm">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="sr-only">{{__('messages.contactlabel_email')}}</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                            </div>
                            <input name="reset" id="reset" class="btn btn-block login-btn mb-4" type="submit" value="{{__('Send reset instructions')}}">
                            <a class="text-decoration-none" href="{{ route('login') }}"><button type="button" class="btn btn-outline-info btn-block btn-sm mb-4">{{ __('Nevermind, I remembered my password') }}</button></a>
                        </form>
                        <a href="{{ route('login') }}">{{__('Back to login')}}</a>
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
