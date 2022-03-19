@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Settings'))

@section('content_header')

    @if (Auth::user()->hasAnyRole('admin'))
        <h4>{{__('Administration')}} / {{__('Settings')}}</h4>
    @else
        <h4>{{__('Application access denied')}}</h4>
    @endif

@stop

@section('css')
    <!-- reuse profile stylesheet -->
    <link rel="stylesheet" href="/css/profile.css" >

@stop

@section('js')

    @if (session()->has('success'))
        <script>
            toastr.success("{{session('success')}}")
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            toastr.error("{{session('error')}}")
        </script>
    @endif

    @if($errors->any())
        @foreach ($errors->all() as $error)
            <script>toastr.error('{{$error}}', '{{__('Validation error!')}}')</script>
        @endforeach
    @endif

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i> {!! __('<b>Available security policies</b> (current policy: :currentPolicySettingValue)', ['currentPolicySettingValue' => $security['secPolicy']]) !!}

            <p>{!! __('<b>Disabled:</b> No security policy will be enforced. This is insecure.') !!}</p>


            <div class="row">

                <div class="col">
                    <p>{!! __("<b>Low:</b> Good choice for low-traffic websites, e.g. community with less than 100 members.") !!}</p>
                    <ul>
                        <li>{{ __('Minimum 10 characters') }}</li>
                    </ul>
                </div>
                <div class="col">
                    <p>{!! __('<b>Medium (recommended):</b> Standard for most websites.') !!}</p>
                    <ul>
                        <li>{{ __('Minimum 12 characters') }}</li>
                        <li>{{ __('Must contain special characters') }}</li>
                        <li>{{ __('Must contain upper and lower case characters') }}</li>
                    </ul>
                </div>
                <div class="col">
                    <p>{!! __('<b>(╯°□°）╯︵ ┻━┻:</b> For security aficionados. More of a nuisance than a good policy.') !!}</p>
                    <ul>
                        <li>{{ __('Minimum 20 characters') }}</li>
                        <li>{{ __('Same as Medium, but: ') }}</li>
                        <ul>
                            <li>{{ __('Must contain numerical characters') }}</li>
                        </ul>
                    </ul>
                </div>

            </div>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        </div>

    </div>

    @if($security['secPolicy'] == 'off')

        <div class="row">

            <div class="col">

                <div class="alert alert-danger">

                    <p>{!! __('<b><i class="fas fa-exclamation-triangle"></i> DANGER: </b> Insecure security policy') !!}</p>

                    <p>{!! __('Your current password security policy is set to <b>off</b>. This allows users to choose potentially unsafe passwords. We strongly recommend you update this value to <b>Medium</b>.') !!}</p>

                </div>

            </div>

        </div>

    @endif

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-header">
                    <h3>{{__('Notification settings')}}</h3>
                    <p>{{__('Change which notifications are sent here.')}}</p>
                </div>

                <div class="card-body">
                    <form name="settings" id="settings" method="post" action="{{route('saveSettings')}}">
                        @csrf
                        @foreach($options as $option)

                           <div class="form-group form-check">
                                <input type="hidden" name="{{$option->option_name}}" value="0">
                                <input type="checkbox" name="{{$option->option_name}}" value="1" id="{{$option->option_name}}" class="form-check-input" {{ ($option->option_value == 1) ? 'checked' : '' }}>
                                <label for="{{$option->option_name}}">{{$option->friendly_name}}</label>
                            </div>

                        @endforeach
                    </form>
                </div>

                <div class="card-footer">
                    <button type="button" class="btn btn-success" onclick="$('#settings').submit()"><i class="fa fa-save"></i> {{__('Save changes')}}</button>
                </div>

            </div>

        </div>

        <div class="col">

            <div class="card">

                <div class="card-header">
                    <h3>{{ __('Security Settings') }}</h3>
                    <p>{{ __('Here, you can configure security settings for the app, for all users.') }}</p>
                </div>

                <div class="card-body">

                    <form name="security" id="security" method="post" action={{ route('saveSecuritySettings') }}>
                        @csrf

                        <div class="form-group">

                            <label for="policy">{{__('Password Security Policy')}}</label>
                            <select class="custom-select form-control" name="secPolicy">

                                <option value="nil" disabled>{{ __('Choose a security policy') }}</option>
                                <option value="off" {{ ($security['secPolicy'] == 'off') ? 'selected' : '' }}>{{ __('Disabled (default)') }}</option>
                                <option value="low" {{ ($security['secPolicy'] == 'low') ? 'selected' : '' }}>{{ __('Low') }}</option>
                                <option value="medium" {{ ($security['secPolicy'] == 'medium') ? 'selected' : '' }}>{{ __('Medium') }}</option>
                                <option value="high" {{ ($security['secPolicy'] == 'high') ? 'selected' : '' }}>{{ __('High (╯°□°）╯︵ ┻━┻') }}</option>

                            </select>

                        </div>

                        <div class="form-group">
                            <label for="graceperiod">{!! __('Grace period for 2FA requirement (above <code>reviewer</code>)') !!}</label>
                            <input type="text" class="form-control" id="graceperiod" placeholder="time in days" name="graceperiod" value="{{$security['graceperiod']}}">
                            <p class="text-muted text-sm"><i class="fas fa-info-circle"></i> {{ __('Users will be locked out after this time period if they fail to enable 2FA. Leave empty to disable.') }}</p>
                        </div>


                        <div class="form-group">
                            <label for="pwExpiry">{{ __('Password Expiry Control') }}</label>
                            <input type="text" class="form-control" id="pwExpiry" placeholder="time in days" name="pwExpiry" value="{{ $security['pwExpiry'] }}">
                            <p class="text-muted text-sm"><i class="fas fa-info-circle"></i> {{ __('Leave this field zeroed to disable. Users will be forced to reset their password after the specified time.') }}</p>
                        </div>


                        <div class="form-group form-check">
                            <input type="hidden" name="enforce2fa" value="0">
                            <input type="checkbox" name="enforce2fa" value="1" id="enforce2fa" class="form-check-input" {{ $security['enforce2fa'] == true ? 'checked' : '' }}>
                            <label for="enforceAdmin2fa">{{ __('Force roles above <code>reviewer</code> to use two factor authentication?') }}</label>
                        </div>

                         <div class="form-group form-check">
                            <input type="hidden" name="requirePMC" value="0">
                            <input type="checkbox" name="requirePMC" value="1" id="requirePMC" class="form-check-input" {{ $security['requiresPMC'] == true ? 'checked' : '' }}>
                            <label for="requirePMC">{{ __('Require a valid game license to signup?') }}</label>
                            <p class="text-muted text-sm"><i class="fas fa-info-circle"></i> {{ __('Choose a game in the section below, if applicable.') }}</p>
                        </div>

                    </form>

                </div>

                <div class="card-footer">
                    <button onclick="$('#security').submit()" type="button" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save Changes') }}</button>
                </div>

            </div>

        </div>

    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card">

                <div class="card-header">
                    <h4>{{ __('Game Integration') }}</h4>
                    <p>{{ __("In this section, you can choose which game your community plays. This gives you the ability to limit signups to users with valid game accounts, keeping pirates out. It also swaps front page images with images for that game, if you haven't customised them. Leave unselected if your community does not revolve around a game.") }}</p>
                </div>

                <div class="card-body">

                    <form method="POST" id="gamePrefForm" action={{ route('saveGameIntegration') }}>
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col">
                                    <label>
                                        <input type="radio" name="gamePref" value="MINECRAFT" {{ ($currentGame == 'MINECRAFT') ? 'checked' : '' }}>
                                        <img alt="Mojang Logo (Minecraft)" height="150px" width="150px" src="/img/mc.jpg">
                                    </label>
                                </div>

                                <div class="col">
                                    <label>
                                        <input type="radio" name="gamePref" value="RUST" {{ ($currentGame == 'RUST') ? 'checked' : '' }}>
                                        <img alt="Rust Logo" height="150px" width="150px" src="/img/rust.png">
                                    </label>
                                </div>


                                <div class="col">
                                    <label>
                                        <input type="radio" name="gamePref" value="GMOD" {{ ($currentGame == 'GMOD') ? 'checked' : '' }}>
                                        <img alt="Gmod Logo" height="150px" width="150px" src="/img/gmod.png">
                                    </label>
                                </div>

                                <div class="col">
                                    <label>
                                        <input type="radio" name="gamePref" value="SE" {{ ($currentGame == 'SE') ? 'checked' : '' }}>
                                        <img alt="Gmod Logo" height="150px" width="150px" src="/img/se.png">
                                    </label>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>

                <div class="card-footer">
                    <button onclick="$('#gamePrefForm').submit()" type="button" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save Changes') }}</button>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-3">

        <div class="col">

            <div class="card">

                <div class="card-header">

                    <h4>{{ __('Integration with 3rd party services') }}</h4>
                    <p>{{ __('Configure any of the thirdy party services below to facilitate recruiting staff for specific services.') }}</p>

                </div>


                <div class="card-body">
                    <div class="form-group mb-3">
                        <div class="row text-center">
                            <div class="col mt-4">
                                <img src="/img/discord-mark-white.svg" width="270px" alt="Discord Workmark Logo - Black"><br>
                                <button class="btn btn-primary mt-4" type="button"><i class="fab fa-discord"></i> {{ __('Configure Integration') }}</button>
                            </div>

                            <div class="col">
                                <img src="/img/reddit-mark-white.svg" width="250px" alt="Reddit Wordmark Logo - OrangeRed"><br>
                                <button class="btn btn-primary mt-4" type="button"><i class="fab fa-reddit"></i> {{ __('Configure Integration') }}</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer">

                    <p class="text-muted text-bold"><i class="fas fa-exclamation-triangle"></i><b> {{ __('Disclaimer:') }} </b> {{ __(':siteNameSettingValue is not affiliated with and does not endorse the brands displayed above.', ['siteNameSettingValue' => config('app.name')]) }}</p>

                </div>
            </div>
        </div>
    </div>


@stop
