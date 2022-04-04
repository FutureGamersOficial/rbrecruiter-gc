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
                        </div> <!-- main content start -->
                        <p class="login-card-description">{{__('adminlte::adminlte.verify_message')}}</p>

                        @if(session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('adminlte::adminlte.verify_email_sent') }}
                            </div>
                        @endif

                        {{ __('adminlte::adminlte.verify_check_your_email') }}
                        {{ __('adminlte::adminlte.verify_if_not_recieved') }},

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <input name="resend" id="resend" class="btn btn-block login-btn mb-4" type="submit" value="{{ __('adminlte::adminlte.verify_request_another') }}">
                        </form>

                        <nav class="login-card-footer-nav">
                            <a href="{{ config('app.terms_url') }}">{{__('Terms of Service')}}</a>
                            <a href="{{ config('app.privacy_url') }}">{{__('Privacy Policy')}}</a>
                            <a href="{{ config('app.guidelines_url') }}">{{__('Community Guidelines')}}</a>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
