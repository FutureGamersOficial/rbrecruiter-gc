@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __(":userNameValue's profile", ['userNameValue' => $profile->user->name]))

@section('content_header')

    <h4>{{__('Users')}} / {{__('Profile')}} / {{ $profile->user->name }}</h4>

@stop

@section('js')

    <script src="/js/app.js"></script>
    <x-global-errors></x-global-errors>

@stop


@section('content')

  @if (is_array($suspensionInfo))

      <div class="alert alert-danger">

          <span><i class="fa fa-ban"></i> <b>{{__('This account has been suspended :suspensionTypeValue', ['suspensionTypeValue' => ($suspensionInfo['isPermanent']) ? __('permanently.') : __('until :date.', ['date' => $suspensionInfo['bannedUntil']])]) }}</b></span>

          <p>{{__('This user has been suspended by the admins. Admins suspend accounts for a variety of reasons, including spam.')}}</p>

          <p>
              <i class="fas fa-chevron-right"></i> <b>{{$suspensionInfo['reason']}}</b>
          </p>

      </div>

  @endif

    @if (Auth::user()->hasRole('admin'))

        <x-modal id="banAccountModal" modal-label="banAccount" modal-title="{{__('Please confirm')}}" include-close-button="true">

            <p>{{__("Please confirm that you want to suspend this account. You'll need to add a reason and expiration date to confirm this.")}}</p>

            <form id="banAccountForm" name="banAccount" method="POST" action="{{route('banUser', ['user' => $profile->user->id])}}">
               @csrf

                @if($demoActive)
                    <div class="alert alert-danger">
                        <p class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
                    </div>
                @endif

                <div class="row">

                    <div class="col">
                        <label for="reason">{{__('Public note')}}</label>
                        <input type="text" name="reason" id="reason" class="form-control" placeholder="{{__('e.g. Spamming')}}">
                    </div>

                    <div class="col">
                        <label for="duration">{{ __('Duration') }}</label>
                        <input type="text" name="duration" id="duration" class="form-control" placeholder="{{ __('in days') }}">
                    </div>
                </div>


                <div class="mt-2">
                    <input type="hidden" name="suspensionType" value="off">

                    <label for="suspensionType">{{ __('Suspension type') }}</label><br>
                    <input type="checkbox" id="suspensionType" name="suspensionType" checked data-toggle="toggle" data-on="Temporary" data-off="Permanent" data-onstyle="success" data-offstyle="danger" data-width="130" data-height="40">
                    <p class="text-muted text-sm"><i class="fas fa-info-circle"></i> {{ __('Temporary suspensions will be automatically lifted. The suspension note is visible to all users. Suspended users will not be able to login or register.') }}</p>
                </div>


            </form>

            <x-slot name="modalFooter">
                <button id="banAccountButton" type="button" class="btn btn-danger" {{ ($demoActive) ? 'disabled' : '' }} ><i class="fa fa-gavel"></i> {{__('Confirm')}}</button>
            </x-slot>

        </x-modal>

        @if (!Auth::user()->is($profile->user) && $profile->user->isStaffMember())
            <x-modal id="terminateUser" modal-label="terminateUser" modal-title="{{__('Please Confirm')}}" include-close-button="true">

                @if($demoActive)
                    <div class="alert alert-danger">
                        <p class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
                    </div>
                @endif

              <p><i class="fa fa-exclamation-triangle"></i> <b>{{__('You are about to terminate a recruited staff member')}}</b></p>
              <p>
                {{__('Terminating a staff member will remove their privileges on the application management site and connected integrations configured for the vacancy they applied for.')}}
              </p>
              <p>
                <b>{{__('THIS PROCESS IS IRREVERSIBLE AND IMMEDIATE')}}</b>
              </p>


              <x-slot name="modalFooter">

                  <form method="POST" action="{{route('terminateStaffMember', ['user' => $profile->user->id])}}" id="terminateUserForm">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning" {{ ($demoActive) ? 'disabled' : '' }}><i class="fas fa-exclamation-circle"></i> {{__('Confirm')}}</button>

                  </form>

              </x-slot>

            </x-modal>
        @endif

        <x-modal id="deleteAccount" modal-label="deleteAccount" modal-title="{{__('messages.reusable.confirm')}}" include-close-button="true">

            @if($demoActive)
                <div class="alert alert-danger">
                    <p class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
                </div>
            @endif

            <p><i class="fa fa-exclamation-triangle"></i><b> {{__('WARNING: This is a potentially destructive action!')}}</b></p>

            <p>{{__("Deleting a user's account is an irreversible process. Historic and current applications, votes, and profile content, as well as any personally identifiable information will be immediately erased.")}}</p>

            <form id="deleteAccountForm" method="POST" action={{route('deleteUser', ['user' => $profile->user->id])}}>

                @csrf
                @method('DELETE')

                <label for="promptConfirm">{{__('Type to confirm: ')}} "DELETE ACCOUNT"</label>
                <input type="text" name="confirmPrompt" class="form-control" placeholder="{{__('Please type the above text')}}">

            </form>

            <x-slot name="modalFooter">

                <button type="button" class="btn btn-danger" {{ ($demoActive) ? 'disabled' : '' }} onclick="document.getElementById('deleteAccountForm').submit()"><i class="fa fa-trash"></i> {{strtoupper(__('Confirm'))}}</button>

            </x-slot>
        </x-modal>

        <x-modal id="ipInfo" modal-label="ipInfo" modal-title="{{__('IP Address Information')}}" include-close-button="true">

            <h4 class="text-center">{{__('Search results')}}</h4>

              @if (!isset($ipInfo->message))

                  <table class="table table-borderless">

                      <tbody>

                          <tr>
                            <th>{{__('Origin country')}}</th>
                            <td>{{$ipInfo->country_name ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('State/Province')}}</th>
                            <td>{{$ipInfo->state_prov ?? 'None'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('District (if any)')}}</th>
                            <td>{{$ipInfo->district ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('City')}}</th>
                            <td>{{$ipInfo->city ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('Postal code')}}</th>
                            <td>{{$ipInfo->zipcode ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('Geographical coordinates')}}</th>
                            <td>{{$ipInfo->latitude ?? 0}}, {{$ipInfo->longitude ?? 0}}</td>
                          </tr>

                          <tr>
                            <th>{{__('European?')}}</th>
                            <td>{{($ipInfo->is_eu) ? __('Yes') : __('No')}}</td>
                          </tr>

                          <tr>
                            <th>{{__('ISP')}}</th>
                            <td>{{$ipInfo->isp ?? 'N/A'}}</td>
                          </tr>


                          <tr>
                            <th>{{__('Organization')}}</th>
                            <td>{{$ipInfo->organization ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('Connection type (e.g. datacenter, home)')}}</th>
                            <td>{{$ipInfo->connection_type ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('Timezone')}}</th>
                            <td>{{$ipInfo->time_zone->name ?? __('N/A')}}</td>
                          </tr>

                      </tbody>

                  </table>

              @else
                <div class="alert alert-danger">

                    <i class="fas fa-exclamation-circle"></i> <b>{{__("This query didn't return any results.")}}</b>
                    <p>
                      {{$ipInfo->message}}
                    </p>

                </div>
              @endif

            <x-slot name="modalFooter"></x-slot>
        </x-modal>

        <x-modal id="editUser" modal-label="editUser" modal-title="{{__('messages.profile.edituser')}}" include-close-button="true">

            @if($demoActive)
                <div class="alert alert-danger">
                    <p class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
                </div>
            @endif

          <form id="updateUserForm" method="post" action="{{ route('updateUser', ['user' => $profile->user->id]) }}">
            @csrf
            @method('PATCH')

            <label for="email">{{__('Email')}}</label>
            <input {{ ($demoActive) ? 'disabled' : '' }} id="email" type="text" name="email" class="form-control" required value="{{ $profile->user->email }}" />

            <label for="name">{{__('Name')}}</label>
            <input {{ ($demoActive) ? 'disabled' : '' }} id="name" type="text" name="name" class="form-control" required value="{{ $profile->user->name }}" />

            <label for="uuid">{{ __('Mojang UUID (deprecated)') }}</label>
            <input {{ ($demoActive) ? 'disabled' : '' }} id="uuid" type="text" name="uuid" class="form-control" required value="{{ $profile->user->uuid ?? "disabled" }}" />
            <p class="text-muted text-sm">
              <i class="fas fa-exclamation-triangle"></i> {{__('messages.profile.edituser_consequence')}}
            </p>

            <div class="form-group mt-3">

              <label>{{__('Roles')}}</label>
              <table class="table table-borderless">
                <tbody>

                  @foreach($roles as $roleName => $status)
                    <tr>
                      <th><input {{ ($demoActive) ? 'disabled' : '' }} type="checkbox" name="roles[]" value="{{ $roleName }}" {{ ($status) ? 'checked' : '' }}></th>
                      <td class="col-md-2">{{ ucfirst($roleName) }}</td>
                    </tr>

                  @endforeach

                </tbody>


              </table>

            </div>

          </form>

          <x-slot name="modalFooter">

              <button type="button" {{ ($demoActive) ? 'disabled' : '' }} class="btn btn-warning" onclick="$('#updateUserForm').submit()"><i class="fa fa-exclamation-cicle"></i> {{__('Save changes')}}</button>

          </x-slot>

        </x-modal>

    @endif



    <div class="row mb-3">

        <div class="col">

            <div class="text-center">
                @if($profile->avatarPreference == 'gravatar')
                    <img class="profile-user-img img-fluid img-circle" src="https://gravatar.com/avatar/{{md5($profile->user->email)}}" alt="{{ __('User profile picture') }}">
                @else
                    <img class="profile-user-img img-fluid img-circle" src="https://crafatar.com/avatars/{{$profile->user->uuid}}" alt="{{ __('User profile picture') }}">
                @endif
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-4 offset-md-4">

            <div class="card">

                <div class="card-body text-center">

                    @if ($profile->user->isBanned())
                        <del><h3>{{$profile->user->name}}</h3></del>
                    @else
                        <h3>{{$profile->user->name}}</h3>
                    @endif

                    <p class="text-muted">{{$profile->profileShortBio}}</p>
                    <p class="text-muted">{{__('Member since :date', ['date' => $since])}}</p>
                    @if (Auth::user()->hasRole('admin'))
                        <button type="button" class="btn btn-sm btn-info" onclick="$('#ipInfo').modal('show')">{{__('Lookup :ipAddress', ['ipAddress' => ($shouldCollect) ? $profile->user->originalIP : '0.0.0.0'])}}</button>
                    @endif

                    @if ($profile->user->is(Auth::user()))
                        <button type="button" class="btn btn-sm btn-warning" onclick="window.location.href='{{route('showProfileSettings')}}'"><i class="fas fa-pencil-alt"></i></button>
                    @elseif (Auth::user()->hasRole('admin') && $profile->user->isStaffMember())
                        <button type="button" class="btn btn-sm btn-danger" onclick="$('#terminateUser').modal('show')">{{__('Terminate Staff Member')}}</button>
                    @endif

                </div>

                <div class="card-footer text-center">

                    @foreach ($profile->user->roles as $role)

                        <span class="badge badge-success mr-2">{{ucfirst($role->name)}}</span>

                    @endforeach

                </div>

            </div>

        </div>

        @if (Auth::user()->hasRole('admin'))

            <div class="col">

                <div class="card">
                    <h5 class="card-header">
                        <a class="collapsed d-block" data-toggle="collapse" href="#collapse-collapsed" aria-expanded="true" aria-controls="collapse-collapsed" id="heading-collapsed">
                            <i class="fa fa-chevron-down pull-right"></i>
                            {{__('Account management (admin)')}}
                        </a>
                    </h5>
                    <div id="collapse-collapsed" class="collapse" aria-labelledby="heading-collapsed">
                        <div class="card-body">

                            <div class="management-btn text-center">

                                @if (!$profile->user->isBanned())
                                    <button class="btn btn-danger mb-2" id="banAccountTrigger"><i class="fa fa-ban"></i> {{__('Suspend')}}</button><br>
                                @else
                                    <form method="post" action="{{route('unbanUser', ['user' => $profile->user->id])}}">

                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-warning mb-2"><i class="fa fa-check"></i> {{__('Lift Suspension')}}</button>

                                    </form>
                                @endif
                                <button class="btn btn-danger mb-2" onclick="$('#deleteAccount').modal('show')"><i class="fas fa-trash-alt"></i> {{__('Delete Account')}}</button><br>

                                <button class="btn btn-warning mb-2" onclick="$('#editUser').modal('show')"><i class="fas fa-pencil-alt"></i> {{__('Edit Account')}}</button><br>
                            </div>

                        </div>
                    </div>
                </div>


            </div><!-- .col -->
        @endif

    </div>

    <div class="row buttonBar">

        <div class="col-md-4 offset-md-4">

            <div class="card" style="border-radius: 50px">

                <div class="card-body text-center">

                    <a href="https://github.com/{{$github}}" class="pr-2 pl-2"><i class="fab fa-github fa-2x"></i></a>
                    <a href="#" onclick="toastr.info('{{__("User's Discord Tag: :discordTag", ['discordTag' => $discord])}}')" class="pr-2 pl-2"><i class="fab fa-discord fa-2x"></i></a>
                    <a href="https://twitter.com/{{$twitter}}" class="pr-2 pl-2"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="https://instagram.com/{{$insta}}" class="pr-2 pl-2"><i class="fab fa-instagram fa-2x"></i></a>


                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card">

            <div class="card-header">
                <h4>{{__('About')}}</h4>
            </div>

            <div class="card-body">

                {{$profile->profileAboutMe}}

            </div>

        </div>

        </div>


    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
