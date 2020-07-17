@extends('adminlte::page')

@section('title', 'Raspberry Network | Account Settings')

@section('content_header')

    <h4>My Profile / Account / Settings</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('css')
    <link rel="stylesheet" href="/css/acc.css">
@stop

@section('content')

    @if (!Auth::user()->has2FA())


      <x-modal id="twoFactorAuthModal" modal-label="2faLabel" modal-title="Two-factor Authentication" include-close-button="true">

        <h3><i class="fas fa-user-shield"></i> We're glad you decided to increase your account's security!</h3>

        <p><b>Supported apps you can install:</b></p>
        <ul>
          <li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"><i class="fab fa-google-play"></i> Google Authenticator</a></li>
        </ul>

        <p>Scan the <i>QR code</i> below with your preferred app, and then copy the code here.</p>


        <div class="row">
          <div class="col-3 offset-3">
            <div class="qr-code-container text-center">

                <img src="{{ $twofaQRCode }}" alt="2FA Security key" />

            </div>
          </div>
        </div>

        <div class="row">

          <div class="col">

            <form method="POST" action="{{ route('enable2FA') }}" id="enable2Fa">
              @csrf
              @method('PATCH')
              <label for="otp">One-time code</label>
              <input type="text" id="otp" name="otp" class="form-control" />

            </form>

          </div>

        </div>



        <x-slot name="modalFooter">

          <button type="button" class="btn btn-success" onclick="$('#enable2Fa').submit()"><i class="fas fa-key"></i> Enable 2FA</button>

        </x-slot>

      </x-modal>

    @endif

    @if (Auth::user()->has2FA())

      <x-modal id="remove2FA" modal-label="remove2FALabel" modal-title="Remove Two-Factor Authentication" include-close-button="true">

        <p><i class="fas fa-exclamation-triangle"></i> <b>Are you sure?</b> Removing two-factor authentication will reduce the security of your account.</p>

        <form action="{{ route('disable2FA') }}" method="POST" id="disable2FA">
          @csrf
          @method('PATCH')
          <label for="currentPassword">Confirm your password to continue</label>
          <input id="currentPassword" type="password" name="currentPassword" class="form-control" required />
          <p class="text-sm text-muted">To prevent unauthorized changes, a password is always required for sensitive operations.</p>

          <div class="form-group mt-2">

            <label for="consent">"I understand the possible consequences of disabling two factor authentication"</label>
            <span><i>Click to confirm  </i> </span><input type="checkbox" name="consent" id="consent" required />

          </div>

        </form>

        <x-slot name="modalFooter">

          <button type="button" class="btn btn-danger" onclick="$('#disable2FA').submit()"><i class="fa fa-trash"></i> Remove 2FA</button>

        </x-slot>

      </x-modal>

    @endif

    <div class="modal fade" tabindex="-1" id="authenticationForm" role="dialog" aria-labelledby="authenticationFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authenticationFormLabel">Please authenticate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">For your security, you'll need to re-enter your password before logging out other devices. If you believe your account has been compromised, please change your password instead, as that will automatically log out anyone else who might using your account, and prevent them from signing back in.</p>

                    <form method="POST" action="{{route('flushSessions')}}" id="flushSessions">
                        @csrf
                        <label for="reenter">Re-enter your password</label>
                        <input type="password" name="currentPasswordFlush" id="currentPasswordFlush" class="form-control" autocomplete="current-password">
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="document.getElementById('flushSessions').submit()">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col text-center">

            <div class="card">

                <div class="card-body">

                    <h3>Welcome back, {{Auth::user()->name}}</h3>

                    <p class="text-muted">{{Auth::user()->email}}</p>
                    <a href="https://namemc.com/profile/{{Auth::user()->uuid}}" target="_blank">View @ NameMC</a>
                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">
            <div class="card mt-3 tab-card">
                <div class="card-header tab-card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="accountSecurityTab" data-toggle="tab" href="#accountSecurity" role="tab" aria-controls="AccountSecurity" aria-selected="true">Account Security</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="twofaTab" data-toggle="tab" href="#twofa" role="tab" aria-controls="TwoFa" aria-selected="false">Two Factor Authentication</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sessionsTab" data-toggle="tab" href="#sessions" role="tab" aria-controls="Sessions" aria-selected="false">Sessions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contactSettingsTab" data-toggle="tab" href="#contactSettings" role="tab" aria-controls="ContactSettings" aria-selected="false">Contact Settings (E-mail)</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-3" id="accountSecurity" role="tabpanel" aria-labelledby="accountSecurityTab">
                        <h5 class="card-title">Change Password</h5>
                        <p class="card-text">Change your password here. This will log you out from all existing sessions for your security.</p>

                        <form method="POST" action="{{route('changePassword')}}" id="changePassword">

                            @csrf
                            @method('PATCH')
                            <label for="oldpassword">Old Password</label>
                            <input class="form-control" name="oldPassword" type="password" id="oldpassword" autocomplete="current-password">
                            <p class="text-sm text-muted">Forgot your password? Reset it <a href="/auth/password/reset">here</a></p>

                            <div class="form-group mt-5">

                                <label for="newpassword">New Password</label>
                                <input type="password" name="newPassword" id="newpassword" class="form-control" autocomplete="new-password">

                                <label for="newpassword_confirmation">Confirm Password</label>
                                <input type="password" name="newPassword_confirmation" id="newpassword_confirmation" autocomplete="new-password" class="form-control">

                            </div>

                        </form>

                        <button class="btn btn-success" type="button" onclick="document.getElementById('changePassword').submit()">Change Password</button>
                    </div>
                    <div class="tab-pane fade p-3" id="twofa" role="tabpanel" aria-labelledby="twofaTab">
                        <h5 class="card-title">Two-factor Authentication</h5>
                        <br />
                        @if (Auth::user()->has2FA())
                            <p><b>Hooray!</b> 2FA is setup correctly for your account. A code will be asked each time you login.</p>
                            <button type="button" class="btn btn-danger" onclick="$('#remove2FA').modal('show')"><i class="fa fa-ban"></i> Disable 2FA (not recommended)</button>
                        @else
                            <p class="card-text"><b>Two-factor auth is available for your account.</b> Enabling this security option greatly increases your account's security in case your password ever gets stolen.</p>
                            <button type="button" class="btn btn-primary" onclick="$('#twoFactorAuthModal').modal('show')">Enable 2FA</button>

                        @endif

                    </div>
                    <div class="tab-pane fade p-3" id="sessions" role="tabpanel" aria-labelledby="sessionsTab">
                        <h5 class="card-title">Session Manager</h5>
                        <p class="card-text">Terminating other sessions is generally a good idea if your account has been compromised.</p>
                        <p>Your current session: Logged in from {{ $ip }}</p>
                        <button type="button" class="btn btn-warning" onclick="$('#authenticationForm').modal('show')">Flush Sessions</button>
                    </div>
                    <div class="tab-pane fade p-3" id="contactSettings" role="tabpanel" aria-labelledby="contactSettingsTab">
                        <h5 class="card-title">Contact Settings</h5>
                        <p class="card-text">Need to change personal data? You can do so here.</p>

                            <form method="POST" action="{{route('changeEmail')}}" id="changeEmail">

                                @csrf
                                @method('PATCH')
                                <div class="form-group">

                                    <label for="oldEmail">Current Email Address</label>
                                    <input type="text" class="form-control" id="oldEmail" disabled value="{{Auth::user()->email}}">


                                    <label for="newEmail">New Email Address</label>
                                    <input type="email" name="newEmail" class="form-control mb-3" id="newEmail">


                                </div>

                                <div class="form-group mt-5">

                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" name="currentPassword" class="form-control" id="currentPassword" autocomplete="current-password">
                                    <p class="text-sm text-muted">For security reasons, you cannot make important account changes without confirming your password. You'll also need to verify your new email.</p>
                                </div>
                            </form>

                        <button class="btn btn-success" type="button" onclick="document.getElementById('changeEmail').submit()">Change Email Address</button>
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
