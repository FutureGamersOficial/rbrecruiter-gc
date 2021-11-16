@extends('breadcrumbs.auth.main')

@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('authpage')

    <div class="container">
        <div class="card login-card">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <img src="{{ asset(config('customization.authbanner')) }}" alt="resetset" class="login-card-img">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <div class="brand-wrapper">
                            <img src="{{ config('adminlte.logo_img') }}" alt="logo" class="logo rounded mr-2">{{ config('adminlte.logo') }}
                        </div>
                        <p class="login-card-description">{{__('Set a new password')}}</p>
                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ $password_reset_url }}" method="POST" id="resetset">
                            @csrf
                            {{-- Token field --}}
                            <input type="hidden" name="token" value="{{ $token }}">

                            {{-- Email field --}}
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>

                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- Password field --}}
                            <div class="input-group mb-3">
                                <input type="password" name="password"
                                       class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       placeholder="{{ __('adminlte::adminlte.password') }}">
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- Password confirmation field --}}
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation"
                                       class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                       placeholder="{{ trans('adminlte::adminlte.retype_password') }}">

                                @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <input name="reset" id="reset" class="btn btn-block login-btn mb-4" type="submit" value="{{__('Change password')}}">
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
