@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.profile.title', ['name' => $profile->user->name]))

@section('content_header')

    <h4>{{__('messages.profile.users')}} / {{__('messages.profile.profile')}} / {{ $profile->user->name }}</h4>

@stop

@section('js')

    <script src="/js/app.js"></script>
    <x-global-errors></x-global-errors>

@stop


@section('content')

  @if ($profile->user->isBanned())

      <div class="alert alert-danger">

          <span><i class="fa fa-ban"></i> <b>{{__('messages.profile.account_banned')}}</b></span>

          <p>{{__('messages.profile.account_banned_exp')}}</p>

          <p>
            <i class="fas fa-chevron-right"></i> <b>{{$profile->user->bans->reason}}</>
          </p>

      </div>

  @endif

    @if (Auth::user()->hasRole('admin'))

        <x-modal id="banAccountModal" modal-label="banAccount" modal-title="{{__('messages.reusable.confirm')}}" include-close-button="true">

            <p>{{__('messages.profile.ban_confirm')}}</p>

            <form id="banAccountForm" name="banAccount" method="POST" action="{{route('banUser', ['user' => $profile->user->id])}}">
               @csrf

                <label for="reason">{{__('messages.reusable.reason')}}</label>
                <input type="text" name="reason" id="reason" class="form-control" placeholder="{{__('messages.profile.p_duration_exp')}}">

                <div class="input-group">
                <input type="text" class="form-control" name="durationOperator" aria-label="{{__('messages.profile.p_duration')}}">
                <div class="input-group-append">
                    <button id="durationDropdown" class="btn btn-outline-secondary dropdown-toggle duration-btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('messages.profile.duration')}}</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Days</a>
                        <a class="dropdown-item" href="#">Weeks</a>
                        <a class="dropdown-item" href="#">Months</a>
                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Years</a>
                    </div>
                </div>
                </div>
                <p class="text-muted text-sm">{{__('messages.profile.leave_empty')}}</p>

                <input id="operator" type="hidden" value="" name="durationOperand" class="duration-operator-fld">

            </form>

            <x-slot name="modalFooter">

                <button id="banAccountButton" type="button" class="btn btn-danger"><i class="fa fa-ban"></i> {{__('messages.profile.ban')}}</button>

            </x-slot>

        </x-modal>

        @if (!Auth::user()->is($profile->user) && $profile->user->isStaffMember())
            <x-modal id="terminateUser" modal-label="terminateUser" modal-title="{{__('messages.reusable.confirm')}}" include-close-button="true">

              <p><i class="fa fa-exclamation-triangle"></i> <b>{{__('messages.profile.terminate_notice')}}</b></p>
              <p>
                {{__('messages.profile.terminate_notice_warning')}}
              </p>
              <p>
                <b>{{__('messages.profile.terminate_notice_consequence')}}</b>
              </p>


              <x-slot name="modalFooter">

                  <form method="POST" action="{{route('terminateStaffMember', ['user' => $profile->user->id])}}" id="terminateUserForm">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning"><i class="fas fa-exclamation-circle"></i> {{__('messages.reusable.confirm')}}</button>

                  </form>

              </x-slot>

            </x-modal>
        @endif

        <x-modal id="deleteAccount" modal-label="deleteAccount" modal-title="{{__('messages.reusable.confirm')}}" include-close-button="true">

            <p><i class="fa fa-exclamation-triangle"></i><b> {{__('messages.profile.delete_acc_warn')}}</b></p>

            <p>{{__('messages.profile.delete_acc_consequence')}}</p>

            <form id="deleteAccountForm" method="POST" action={{route('deleteUser', ['user' => $profile->user->id])}}>

                @csrf
                @method('DELETE')

                <label for="promptConfirm">{{__('messages.profile.type_to_confirm')}} "DELETE ACCOUNT"</label>
                <input type="text" name="confirmPrompt" class="form-control" placeholder="{{__('messages.profile.type_placeholder')}}">

            </form>

            <x-slot name="modalFooter">

                <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteAccountForm').submit()"><i class="fa fa-trash"></i> {{strtoupper(__('messages.reusable.confirm'))}}</button>

            </x-slot>
        </x-modal>

        <x-modal id="ipInfo" modal-label="ipInfo" modal-title="{{__('messages.reusable.ip_info')}} {{$ipInfo->ip ?? 'Unknown'}}" include-close-button="true">

            <h4 class="text-center">{{__('messages.profile.search_result')}}</h3>

              @if (!isset($ipInfo->message))

                  <table class="table table-borderless">

                      <tbody>

                          <tr>
                            <th>{{__('messages.profile.origin_cc')}}</th>
                            <td>{{$ipInfo->country_name ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.state_prov')}}</th>
                            <td>{{$ipInfo->state_prov ?? 'None'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.district')}}</th>
                            <td>{{$ipInfo->district ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.city')}}</th>
                            <td>{{$ipInfo->city ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.zipcode')}}</th>
                            <td>{{$ipInfo->zipcode ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.coords')}}</th>
                            <td>{{$ipInfo->latitude ?? 0}}, {{$ipInfo->longitude ?? 0}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.european')}}</th>
                            <td>{{($ipInfo->is_eu) ? __('messages.reusable.yes') : __('messages.reusable.no')}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.isp')}}</th>
                            <td>{{$ipInfo->isp ?? 'N/A'}}</td>
                          </tr>


                          <tr>
                            <th>{{__('messages.profile.org')}}</th>
                            <td>{{$ipInfo->organization ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.ctype')}}</th>
                            <td>{{$ipInfo->connection_type ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>{{__('messages.profile.timezone')}}</th>
                            <td>{{$ipInfo->time_zone->name ?? 'N/A'}}</td>
                          </tr>

                      </tbody>

                  </table>

              @else
                <div class="alert alert-danger">

                    <i class="fas fa-exclamation-circle"></i> <b>{{__('messages.profile.noresults')}}</b>
                    <p>
                      {{$ipInfo->message}}
                    </p>

                </div>
              @endif

            <x-slot name="modalFooter"></x-slot>
        </x-modal>

        <x-modal id="editUser" modal-label="editUser" modal-title="{{__('messages.profile.edituser')}}" include-close-button="true">

          <form id="updateUserForm" method="post" action="{{ route('updateUser', ['user' => $profile->user->id]) }}">
            @csrf
            @method('PATCH')

            <label for="email">{{__('messages.contactlabel_email')}}</label>
            <input id="email" type="text" name="email" class="form-control" required value="{{ $profile->user->email }}" />

            <label for="name">{{__('messages.contactlabel_name')}}</label>
            <input id="name" type="text" name="name" class="form-control" required value="{{ $profile->user->name }}" />

            <label for="uuid">Mojang UUID</label>
            <input id="uuid" type="text" name="uuid" class="form-control" required value="{{ $profile->user->uuid }}" />
            <p class="text-muted text-sm">
              <i class="fas fa-exclamation-triangle"></i> {{__('messages.profile.edituser_consequence')}}
            </p>

            <div class="form-group mt-3">

              <label>{{__('messages.reusable.roles')}}</label>
              <table class="table table-borderless">
                <tbody>

                  @foreach($roles as $roleName => $status)
                    <tr>
                      <th><input type="checkbox" name="roles[]" value="{{ $roleName }}" {{ ($status) ? 'checked' : '' }}></th>
                      <td class="col-md-2">{{ ucfirst($roleName) }}</td>
                    </tr>

                  @endforeach

                </tbody>


              </table>

            </div>

          </form>

          <x-slot name="modalFooter">

              <button type="button" class="btn btn-warning" onclick="$('#updateUserForm').submit()"><i class="fa fa-exclamation-cicle"></i> {{__('messages.vacancy.save')}}</button>

          </x-slot>

        </x-modal>

    @endif



    <div class="row mb-3">

        <div class="col">

            <div class="text-center">
                @if($profile->avatarPreference == 'gravatar')
                    <img class="profile-user-img img-fluid img-circle" src="https://gravatar.com/avatar/{{md5($profile->user->email)}}" alt="User profile picture">
                @else
                    <img class="profile-user-img img-fluid img-circle" src="https://crafatar.com/avatars/{{$profile->user->uuid}}" alt="User profile picture">
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
                    <p class="text-muted">{{__('messages.reusable.member_since', ['date' => $since])}}</p>
                    @if (Auth::user()->hasRole('admin'))
                        <button type="button" class="btn btn-sm btn-info" onclick="$('#ipInfo').modal('show')">{{__('messages.reusable.lookup', ['ipAddress' => $profile->user->originalIP])}}</button>
                    @endif

                    @if ($profile->user->is(Auth::user()))
                        <button type="button" class="btn btn-sm btn-warning" onclick="window.location.href='{{route('showProfileSettings')}}'"><i class="fas fa-pencil-alt"></i></button>
                    @elseif (Auth::user()->hasRole('admin') && $profile->user->isStaffMember())
                        <button type="button" class="btn btn-sm btn-danger" onclick="$('#terminateUser').modal('show')">{{__('messages.profile.terminate_txt')}}</button>
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
                            {{__('messages.profile.acc_management')}}
                        </a>
                    </h5>
                    <div id="collapse-collapsed" class="collapse" aria-labelledby="heading-collapsed">
                        <div class="card-body">

                            <div class="management-btn text-center">

                                @if (!$profile->user->isBanned())
                                    <button class="btn btn-danger mb-2" id="banAccountTrigger"><i class="fa fa-ban"></i> {{__('messages.profile.ban_acc')}}</button><br>
                                @else
                                    <form method="post" action="{{route('unbanUser', ['user' => $profile->user->id])}}">

                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-warning mb-2"><i class="fa fa-check"></i> {{__('messages.profile.unban_acc')}}</button>

                                    </form>
                                @endif
                                <button class="btn btn-danger mb-2" onclick="$('#deleteAccount').modal('show')"><i class="fas fa-trash-alt"></i> {{__('messages.profile.delete_acc')}}</button><br>

                                <button class="btn btn-warning mb-2" onclick="$('#editUser').modal('show')"><i class="fas fa-pencil-alt"></i> {{__('messages.profile.edit_acc')}}</button><br>
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
                    <a href="#" onclick="toastr.info('{{__('messages.profile.discord_tag', ['discordTag' => $discord])}}')" class="pr-2 pl-2"><i class="fab fa-discord fa-2x"></i></a>
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
                <h4>{{__('messages.reusable.abt')}}</h4>
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
