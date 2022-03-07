@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.profile.account_settings'))

@section('content_header')

    <h4>{{__('messages.reusable.profile')}} / {{__('messages.reusable.acc')}} / {{__('messages.reusable.settings')}}</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('css')
    <link rel="stylesheet" href="/css/acc.css">
@stop

@section('content')

    <x-modal id="deleteAccountModal" modal-label="deleteAccountModalLabel" modal-title="Close account" include-close-button="true">

        @if ($demoActive)

            <div class="alert alert-danger">
                <p class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
            </div>

        @endif

        <p>{{ __('Deleting your account is an irreversible process. The following data will be deleted (including personally identifiable data):') }}</p>
        <ul>
            <li>{{ __('Last IP address') }}</li>
            <li>{{ __('Name, Email and MC Username') }}</li>
            <li>{{ __('Your previous applications') }}</li>
            <li>{{ __('Your profile data and preferences') }}</li>
            <li>{{ __('If you were a staff member:') }}</li>
            <ul>
                <li>{{ __('Your comments') }}</li>
                <li>{{ __('Any votes') }}</li>
                <li>{{ __('Your roles') }}</li>
            </ul>
        </ul>
        <p>{{ __('What is not deleted:') }}</p>
        <ul>
            <li>{{ __('Server logs of your visits, including IP addresses') }}</li>
        </ul>

        <p>{{ __("Note: After you verify your identity, you'll receive an email with more information asking you to confirm this request.") }}</p>

        <form id="deleteAccountForm" method="POST" action="{{ route('userDelete') }}">

            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="currentPassword">{{ __('Re-enter your password') }}</label>
                <input class="form-control" autocomplete="current-password" type="password" name="currentPassword" id="currentPassword" required>
                <p class="text-muted text-sm"><i class="fas fa-info-circle"></i> {{ __('For your security, your password is always required for sensitive operations.') }} <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a></p>
            </div>

            @if (Auth::user()->has2FA())
                <div class="form-group mt-5">

                    <label for="otp">{{ __('Two-factor authentication code') }}</label>
                    <input type="text" id="otp" name="otp" class="form-control">
                    <p class="text-muted text-sm"><i class="fas fa-info-circle"></i> {{ __('You cannot recover lost 2FA secrets.') }}</p>

                </div>
            @endif

        </form>

        <x-slot name="modalFooter">

            <button {{ ($demoActive) ? 'disabled' : '' }} onclick="$('#deleteAccountForm').submit()" type="button" class="btn btn-warning"><i class="fas fa-exclamation-triangle"></i> {{ __('Continue') }}</button>

        </x-slot>

    </x-modal>

    @if (!Auth::user()->has2FA())



      <x-modal id="twoFactorAuthModal" modal-label="2faLabel" modal-title="{{__('messages.2fa_txt')}}" include-close-button="true">

          @if($demoActive)
              <div class="alert alert-danger">
                  <p class="font-weight-bold"><i class="fa fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
              </div>
          @endif

        <h3><i class="fas fa-user-shield"></i> {{__('messages.profile.2fa_welcome')}}</h3>

        <p><b>{{__('messages.profile.supported_apps')}}</b></p>
        <ul>
          <li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"><i class="fab fa-google-play"></i> Google Authenticator</a></li>
        </ul>

        <p>{{__('messages.profile.scan_code', ['scannable', 'QR'])}}</p>


        <div class="row">
          <div class="col-3 offset-3">
            <div class="qr-code-container text-center">
                {!! $twofaQRCode !!}
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col">

            <form method="POST" action="{{ route('enable2FA') }}" id="enable2Fa">
              @csrf
              @method('PATCH')
              <label for="otp">{{__('messages.profile.otp')}}</label>
              <input type="text" id="otp" name="otp" class="form-control" />

            </form>

          </div>

        </div>



        <x-slot name="modalFooter">

          <button {{ ($demoActive) ? 'disabled' : '' }} type="button" class="btn btn-success" onclick="$('#enable2Fa').submit()"><i class="fas fa-key"></i> {{__('messages.profile.2fa_enable')}}</button>

        </x-slot>

      </x-modal>

    @endif

    @if (Auth::user()->has2FA())

      <x-modal id="remove2FA" modal-label="remove2FALabel" modal-title="{{__('messages.profile.2fa_remove_extended')}}" include-close-button="true">

        <p><i class="fas fa-exclamation-triangle"></i> <b>{{__('messages.application_m.modal_confirm')}}</b> {{__('messages.profile.2fa_remove_consequence')}}</p>

        <form action="{{ route('disable2FA') }}" method="POST" id="disable2FA">
          @csrf
          @method('PATCH')
          <label for="currentPassword">{{__('messages.profile.2fa_password_confirm')}}</label>
          <input id="currentPassword" type="password" name="currentPassword" class="form-control" required />
          <p class="text-sm text-muted">{{__('messages.profile.2fa_password_confirm_exp')}}</p>

          <div class="form-group mt-2">

            <label for="consent">{{__('messages.profile.2fa_disable_consent')}}</label>
            <span><i>{{__('messages.reusable.confirm_click')}}  </i> </span><input type="checkbox" name="consent" id="consent" required />

          </div>

        </form>

        <x-slot name="modalFooter">

          <button type="button" class="btn btn-danger" onclick="$('#disable2FA').submit()"><i class="fa fa-trash"></i> {{__('messages.profile.2fa_remove')}}</button>

        </x-slot>

      </x-modal>

    @endif

    <div class="modal fade" tabindex="-1" id="authenticationForm" role="dialog" aria-labelledby="authenticationFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authenticationFormLabel">{{__('messages.reusable.auth_req')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">{{__('messages.profile.security_lgotherdev')}}</p>

                    <form method="POST" action="{{route('flushSessions')}}" id="flushSessions">
                        @csrf
                        <label for="reenter">{{__('messages.profile.password_reenter')}}</label>
                        <input type="password" name="currentPasswordFlush" id="currentPasswordFlush" class="form-control" autocomplete="current-password">
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="document.getElementById('flushSessions').submit()">{{__('messages.reusable.confirm')}}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.modal_close')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col text-center">

            <div class="card">

                <div class="card-body">

                    <h3>{{__('messages.welcome_back')}} {{Auth::user()->name}}</h3>

                    <p class="text-muted">{{Auth::user()->email}}</p>
                    <a href="https://namemc.com/profile/{{Auth::user()->uuid}}" target="_blank">{{__('messages.reusable.view')}} @ NameMC</a>
                </div>

            </div>

        </div>

    </div>

    @if(session('passwordExpired'))

        <div class="row">
            <div class="col">
                <div class="alert alert-warning">
                    <p><i class="fas fa-exclamation-triangle"></i><b> {{ __('Your password has expired') }}</b></p>
                    <p>
                        {{ __('You\'ve been redirected here because your password has expired. All users must change their password every :numDaysChangePw days. This is put in place to make sure user accounts remain secure.', ['numDaysChangePw' => \App\Facades\Options::getOption('password_expiry')]) }}
                    </p>

                    <p>{{ __('Please change update your password now. You won\'t be able to use the site until you do this.') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="row">

        <div class="col">
            <div class="card mt-3 tab-card">
                <div class="card-header tab-card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="accountSecurityTab" data-toggle="tab" href="#accountSecurity" role="tab" aria-controls="AccountSecurity" aria-selected="true">{{__('messages.profile.acc_security')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="twofaTab" data-toggle="tab" href="#twofa" role="tab" aria-controls="TwoFa" aria-selected="false">{{__('messages.profile.2fa')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sessionsTab" data-toggle="tab" href="#sessions" role="tab" aria-controls="Sessions" aria-selected="false">{{__('messages.profile.sessions')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contactSettingsTab" data-toggle="tab" href="#contactSettings" role="tab" aria-controls="ContactSettings" aria-selected="false">{{__('messages.profile.contact_settings')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="dangerZoneTab" data-toggle="tab" href="#dangerZone" role="tab" aria-controls="DangerZone" aria-selected="false">{{ __('Danger Zone') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-3" id="accountSecurity" role="tabpanel" aria-labelledby="accountSecurityTab">
                        @if($demoActive)
                            <div class="alert alert-danger">
                                <p class="font-weight-bold"><i class="fa fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
                            </div>
                        @endif

                        <h5 class="card-title">{{__('messages.profile.change_password')}}</h5>
                        <p class="card-text">{{__('messages.profile.change_password_exp')}}</p>

                        <form method="POST" action="{{route('changePassword')}}" id="changePassword">

                            @csrf
                            @method('PATCH')
                            <label for="oldpassword">{{__('messages.profile.old_pass')}}</label>
                            <input class="form-control" name="oldPassword" type="password" id="oldpassword" autocomplete="current-password">
                            <p class="text-sm text-muted">{{__('messages.forgot_pw', ['link' => '<a href="/auth/password/reset">' . __('messages.reusable.here') . '</a>'])}}</p>

                            <div class="form-group mt-5">

                                <label for="newpassword">{{__('messages.profile.new_pw')}}</label>
                                <input type="password" name="newPassword" id="newpassword" class="form-control" autocomplete="new-password">

                                <label for="newpassword_confirmation">{{__('messages.sronly_confirmpassword')}}</label>
                                <input type="password" name="newPassword_confirmation" id="newpassword_confirmation" autocomplete="new-password" class="form-control">

                            </div>

                        </form>

                        <button {{ ($demoActive) ? 'disabled' : '' }} class="btn btn-success" type="button" onclick="document.getElementById('changePassword').submit()">{{__('messages.profile.change_password')}}</button>
                    </div>
                    <div class="tab-pane fade p-3" id="twofa" role="tabpanel" aria-labelledby="twofaTab">
                        <h5 class="card-title">{{__('messages.profile.2fa')}}</h5>
                        <br />
                        @if (Auth::user()->has2FA())
                            <p>{{__('messages.profile.2fa_enable_success')}}</p>
                            <button type="button" class="btn btn-danger" onclick="$('#remove2FA').modal('show')"><i class="fa fa-ban"></i>{{__('messages.profile.2fa_remove')}}</button>
                        @else
                            <p class="card-text"><b>{{__('messages.profile.2fa_avail')}}</b>{{__('messages.profile.2fa_avail_exp')}}</p>
                            <button type="button" class="btn btn-primary" onclick="$('#twoFactorAuthModal').modal('show')">{{__('messages.profile.2fa_enable')}}</button>

                        @endif

                    </div>
                    <div class="tab-pane fade p-3" id="sessions" role="tabpanel" aria-labelledby="sessionsTab">
                        <h5 class="card-title">{{__('messages.profile.session_manager')}}</h5>
                        <p class="card-text">{{__('messages.profile.terminate_others')}}</p>
                        <p>{{__('messages.profile.current_session', ['ipAddress' => (!$shouldCollect) ? '0.0.0.0 (censored)' : $ip])}}</p>
                        <button type="button" class="btn btn-warning" onclick="$('#authenticationForm').modal('show')">{{__('messages.profile.flush_session')}}</button>
                    </div>
                    <div class="tab-pane fade p-3" id="contactSettings" role="tabpanel" aria-labelledby="contactSettingsTab">
                        @if($demoActive)
                            <div class="alert alert-danger">
                                <p class="font-weight-bold"><i class="fa fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
                            </div>
                        @endif
                        <h5 class="card-title">{{__('messages.profile.contact_settings')}}</h5>
                        <p class="card-text">{{__('messages.profile.personal_data_change')}}</p>

                            <form method="POST" action="{{route('changeEmail')}}" id="changeEmail">

                                @csrf
                                @method('PATCH')
                                <div class="form-group">

                                    <label for="oldEmail">{{__('messages.profile.current_email')}}</label>
                                    <input type="text" class="form-control" id="oldEmail" disabled value="{{Auth::user()->email}}">


                                    <label for="newEmail">{{__('messages.profile.new_email')}}</label>
                                    <input type="email" name="newEmail" class="form-control mb-3" id="newEmail">


                                </div>

                                <div class="form-group mt-5">

                                    <label for="currentPassword">{{__('messages.profile.current_password')}}</label>
                                    <input type="password" name="currentPassword" class="form-control" id="currentPassword" autocomplete="current-password">
                                    <p class="text-sm text-muted">{{__('messages.profile.security_nochangepw')}}</p>
                                </div>
                            </form>

                        <button {{ ($demoActive) ? 'disabled' : '' }} class="btn btn-success" type="button" onclick="document.getElementById('changeEmail').submit()">{{__('messages.profile.change_email')}}</button>
                    </div>


                    <div class="tab-pane fade p-3" id="dangerZone" role="tabpanel" aria-labelledby="dangerZoneTab">
                        <h5 class="card-title">{{ __('Danger Zone') }}</h5>
                        <p class="card-text text-bold"><i class="fas fa-radiation"></i> {{ __('Careful! Actions in these tab might result in irreversible loss of data.') }}</p>

                        <button onclick="$('#deleteAccountModal').modal('show')" rel="buttonTxtTooltip" data-toggle="tooltip" data-placement="top" title="This action will delete your account permanently." class="btn btn-danger" type="button"><i class="fas fa-user-slash"></i> Close Account</button>

                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>

@stop
@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
