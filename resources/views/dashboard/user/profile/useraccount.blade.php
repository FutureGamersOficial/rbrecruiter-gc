@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Account Settings'))

@section('content_header')

    <h4>{{__('My Profile')}} / {{__('Account')}} / {{__('Settings')}}</h4>

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
            <li>{{ __('Any other information stored in your user profile') }}</li>
            @role('reviewer')
                <li>{{ __('Since you are a staff member, the following is also removed:') }}</li>
                <ul>
                    <li>{{ __('Your comments') }}</li>
                    <li>{{ __('Any votes') }}</li>
                    <li>{{ __('Your roles') }}</li>
                    <li>{{ __('Your files on any team') }}</li>
                </ul>
            @endrole
        </ul>
        <p>{{ __('What is not deleted:') }}</p>
        <ul>
            <li>{{ __('Server logs of your visits, including IP addresses') }}</li>
        </ul>

        <p>{{ __("Note: After you verify your identity, you'll receive an email with more information asking you to confirm or cancel this request.") }}</p>
        <p>{{ __('Your account will be locked during this process.') }}</p>

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



      <x-modal id="twoFactorAuthModal" modal-label="2faLabel" modal-title="{{__('Two-Factor Authentication')}}" include-close-button="true">

          @if($demoActive)
              <div class="alert alert-danger">
                  <p class="font-weight-bold"><i class="fa fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
              </div>
          @endif

        <h3><i class="fas fa-user-shield"></i> {{__("We're glad you decided to increase your account's security!")}}</h3>

        <p><b>{{__('Supported apps you can install:')}}</b></p>
        <ul>
          <li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"><i class="fab fa-google-play"></i> Google Authenticator</a></li>
        </ul>

        <p>{{__('Scan the QR code with your preferred app, and then copy the code here.')}}</p>


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
              <label for="otp">{{__('One-time code')}}</label>
              <input type="text" id="otp" name="otp" class="form-control" />

            </form>

          </div>

        </div>



        <x-slot name="modalFooter">

          <button {{ ($demoActive) ? 'disabled' : '' }} type="button" class="btn btn-success" onclick="$('#enable2Fa').submit()"><i class="fas fa-key"></i> {{__('Enable 2FA')}}</button>

        </x-slot>

      </x-modal>

    @endif

    @if (Auth::user()->has2FA())

      <x-modal id="remove2FA" modal-label="remove2FALabel" modal-title="{{__('Remove Two-Factor Authentication')}}" include-close-button="true">

        <p><i class="fas fa-exclamation-triangle"></i> <b>{{__('Are you sure?')}}</b> {{__('Removing two-factor authentication will reduce the security of your account.')}}</p>

        <form action="{{ route('disable2FA') }}" method="POST" id="disable2FA">
          @csrf
          @method('PATCH')
          <label for="currentPassword">{{__('Confirm your password to continue')}}</label>
          <input id="currentPassword" type="password" name="currentPassword" class="form-control" required />
          <p class="text-sm text-muted">{{__('To prevent unauthorized changes, a password is always required for sensitive operations.')}}</p>

          <div class="form-group mt-2">

            <label for="consent">{{__('"I understand the possible consequences of disabling two factor authentication"')}}</label>
            <span><i>{{__('Click to Confirm')}}  </i> </span><input type="checkbox" name="consent" id="consent" required />

          </div>

        </form>

        <x-slot name="modalFooter">

          <button type="button" class="btn btn-danger" onclick="$('#disable2FA').submit()"><i class="fa fa-trash"></i> {{__('Remove 2FA')}}</button>

        </x-slot>

      </x-modal>

    @endif

    <div class="modal fade" tabindex="-1" id="authenticationForm" role="dialog" aria-labelledby="authenticationFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authenticationFormLabel">{{__('Please authenticate')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">{{__("For your security, you'll need to re-enter your password before logging out other devices. If you believe your account has been compromised, please change your password instead, as that will automatically log out anyone else who might using your account, and prevent them from signing back in.")}}</p>

                    <form method="POST" action="{{route('flushSessions')}}" id="flushSessions">
                        @csrf
                        <label for="reenter">{{__('Re-enter your password')}}</label>
                        <input type="password" name="currentPasswordFlush" id="currentPasswordFlush" class="form-control" autocomplete="current-password">
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="document.getElementById('flushSessions').submit()">{{__('Confirm')}}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col text-center">

            <div class="card">

                <div class="card-body">

                    <h3>{{__('Welcome back, :userNameValue!', ['userNameValue' => Auth::user()->name])}}</h3>

                    <p class="text-muted">{{Auth::user()->email}}</p>
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
                        {{ __("You've been redirected here because your password has expired. All users must change their password every :numDaysChangePw days. This is put in place to make sure user accounts remain secure.", ['numDaysChangePw' => \App\Facades\Options::getOption('password_expiry')]) }}
                    </p>

                    <p>{{ __("Please change update your password now. You won't be able to use the site until you do this.") }}</p>
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
                            <a class="nav-link" id="accountSecurityTab" data-toggle="tab" href="#accountSecurity" role="tab" aria-controls="AccountSecurity" aria-selected="true">{{__('Account Security')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="twofaTab" data-toggle="tab" href="#twofa" role="tab" aria-controls="TwoFa" aria-selected="false">{{__('Two Factor Authentication')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sessionsTab" data-toggle="tab" href="#sessions" role="tab" aria-controls="Sessions" aria-selected="false">{{__('Active sessions')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contactSettingsTab" data-toggle="tab" href="#contactSettings" role="tab" aria-controls="ContactSettings" aria-selected="false">{{__('Contact settings')}}</a>
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

                        <h5 class="card-title">{{__('Change Password')}}</h5>
                        <p class="card-text">{{__('Change your password here. This will log you out from all existing sessions for your security.')}}</p>

                        <form method="POST" action="{{route('changePassword')}}" id="changePassword">

                            @csrf
                            @method('PATCH')
                            <label for="oldpassword">{{__('Old Password')}}</label>
                            <input class="form-control" name="oldPassword" type="password" id="oldpassword" autocomplete="current-password">
                            <p class="text-sm text-muted">{!! __('Forgot password? Reset it <a href="/auth/password/reset">here</a>!') !!}</p>

                            <div class="form-group mt-5">

                                <label for="newpassword">{{__('New Password')}}</label>
                                <input type="password" name="newPassword" id="newpassword" class="form-control" autocomplete="new-password">

                                <label for="newpassword_confirmation">{{__('Confirm Password')}}</label>
                                <input type="password" name="newPassword_confirmation" id="newpassword_confirmation" autocomplete="new-password" class="form-control">

                            </div>

                        </form>

                        <button {{ ($demoActive) ? 'disabled' : '' }} class="btn btn-success" type="button" onclick="document.getElementById('changePassword').submit()">{{__('Change Password')}}</button>
                    </div>
                    <div class="tab-pane fade p-3" id="twofa" role="tabpanel" aria-labelledby="twofaTab">
                        <h5 class="card-title">{{__('Two Factor Authentication')}}</h5>
                        <br />
                        @if (Auth::user()->has2FA())
                            <p>{{__('Hooray! 2FA is setup correctly for your account. A code will be asked each time you login.')}}</p>
                            <button type="button" class="btn btn-danger" onclick="$('#remove2FA').modal('show')"><i class="fa fa-ban"></i>{{__('Remove 2FA')}}</button>
                        @else
                            <p class="card-text"><b>{{__('Two-factor auth is available for your account.')}}</b>{{__("Enabling this security option greatly increases your account's security in case your password ever gets stolen.")}}</p>
                            <button type="button" class="btn btn-primary" onclick="$('#twoFactorAuthModal').modal('show')">{{__('Enable 2FA')}}</button>

                        @endif

                    </div>
                    <div class="tab-pane fade p-3" id="sessions" role="tabpanel" aria-labelledby="sessionsTab">
                        <h5 class="card-title">{{__('Session Manager')}}</h5>
                        <p class="card-text">{{__('Terminating other sessions is a mustif your account has been compromised.')}}</p>
                        <p>{{__('Your current session: logged in from :ipAddress', ['ipAddress' => (!$shouldCollect) ? __('0.0.0.0 (censored)') : $ip])}}</p>
                        <button type="button" class="btn btn-warning" onclick="$('#authenticationForm').modal('show')">{{__('Flush sessions')}}</button>
                    </div>
                    <div class="tab-pane fade p-3" id="contactSettings" role="tabpanel" aria-labelledby="contactSettingsTab">
                        @if($demoActive)
                            <div class="alert alert-danger">
                                <p class="font-weight-bold"><i class="fa fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
                            </div>
                        @endif
                        <h5 class="card-title">{{__('Contact settings')}}</h5>
                        <p class="card-text">{{__('Need to change personal data? You can do so here.')}}</p>

                            <form method="POST" action="{{route('changeEmail')}}" id="changeEmail">

                                @csrf
                                @method('PATCH')
                                <div class="form-group">

                                    <label for="oldEmail">{{__('Current Email Address')}}</label>
                                    <input type="text" class="form-control" id="oldEmail" disabled value="{{Auth::user()->email}}">


                                    <label for="newEmail">{{__('New Email Address')}}</label>
                                    <input type="email" name="newEmail" class="form-control mb-3" id="newEmail">


                                </div>

                                <div class="form-group mt-5">

                                    <label for="currentPassword">{{__('Current Password')}}</label>
                                    <input type="password" name="currentPassword" class="form-control" id="currentPassword" autocomplete="current-password">
                                    <p class="text-sm text-muted">{{__('For security reasons, you cannot make important account changes without confirming your password. You will also need to verify your new email address.')}}</p>
                                </div>
                            </form>

                        <button {{ ($demoActive) ? 'disabled' : '' }} class="btn btn-success" type="button" onclick="document.getElementById('changeEmail').submit()">{{__('Change Email Address')}}</button>
                    </div>


                    <div class="tab-pane fade p-3" id="dangerZone" role="tabpanel" aria-labelledby="dangerZoneTab">
                        <h5 class="card-title">{{ __('Danger Zone') }}</h5>
                        <p class="card-text text-bold"><i class="fas fa-radiation"></i> {{ __('Careful! Actions in these tab might result in irreversible loss of data.') }}</p>

                        <button onclick="$('#deleteAccountModal').modal('show')" rel="buttonTxtTooltip" data-toggle="tooltip" data-placement="top" title="{{ __('This action will delete your account permanently.') }}" class="btn btn-danger" type="button"><i class="fas fa-user-slash"></i> {{ __('Close Account') }}</button>

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
