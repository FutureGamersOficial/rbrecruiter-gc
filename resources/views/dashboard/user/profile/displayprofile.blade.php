@extends('adminlte::page')

@section('title', 'Raspberry Network | ' . $profile->user->name . '\'s profile')

@section('content_header')

    <h4>Users / Profile / {{ $profile->user->name }}</h4>

@stop

@section('js')

    <script src="/js/app.js"></script>
    <x-global-errors></x-global-errors>

@stop


@section('content')

  @if ($profile->user->isBanned())

      <div class="alert alert-danger">

          <span><i class="fa fa-ban"></i> <b>Account banned</b></span>

          <p>This user has been banned by the moderators.</p>

          <p>
            <i class="fas fa-chevron-right"></i> <b>{{$profile->user->bans->reason}}</>
          </p>

      </div>

  @endif

    @if (Auth::user()->hasRole('admin'))

        <x-modal id="banAccountModal" modal-label="banAccount" modal-title="Please confirm" include-close-button="true">

            <p>Please confirm that you want to ban this user account. You'll need to add a reason and expiration date to confirm this. Bans don't transfer to connected Minecraft networks (yet).</p>

            <form id="banAccountForm" name="banAccount" method="POST" action="{{route('banUser', ['user' => $profile->user->id])}}">
               @csrf

                <label for="reason">Reason</label>
                <input type="string" name="reason" id="reason" class="form-control" placeholder="e.g. Spamming">

                <div class="input-group">
                <input type="text" class="form-control" name="durationOperand" aria-label="Punishment duration">
                <div class="input-group-append">
                    <button id="durationDropdown" class="btn btn-outline-secondary dropdown-toggle duration-btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Duration</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Days</a>
                        <a class="dropdown-item" href="#">Weeks</a>
                        <a class="dropdown-item" href="#">Months</a>
                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Years</a>
                    </div>
                </div>
                </div>
                <p class="text-muted text-sm">Leave empty for a permanent ban</p>

                <input id="operator" type="hidden" value="" name="durationOperator" class="duration-operator-fld">

            </form>

            <x-slot name="modalFooter">

                <button id="banAccountButton" type="button" class="btn btn-danger"><i class="fa fa-ban"></i> Ban</button>

            </x-slot>

        </x-modal>

        @if (!Auth::user()->is($profile->user) && $profile->user->isStaffMember())
            <x-modal id="terminateUser" modal-label="terminateUser" modal-title="Please confirm" include-close-button="true">

              <p><i class="fa fa-exclamation-triangle"></i> <b>You are about to terminate a staff member</b></p>
              <p>
                Terminating a staff member will remove their privileges on the team management site and Network.
                They will be notified of their termination. Make sure to have discussed this with them first.
              </p>
              <p>
                <b>THIS PROCESS IS IRREVERSIBLE AND IMMEDIATE</b>
              </p>


              <x-slot name="modalFooter">

                  <form method="POST" action="{{route('terminateStaffMember', ['user' => $profile->user->id])}}" id="terminateUserForm">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning"><i class="fas fa-exclamation-circle"></i> Confirm</button>

                  </form>

              </x-slot>

            </x-modal>
        @endif

        <x-modal id="deleteAccount" modal-label="deleteAccount" modal-title="Please confirm" include-close-button="true">

            <p><i class="fa fa-exclamation-triangle"></i><b> WARNING: This is a potentially destructive action!</b></p>

            <p>Deleting a user's account is an irreversible process. Historic and current applications, votes, and profile content, as well as any personally identifiable information will be immediately erased.</p>

            <form id="deleteAccountForm" method="POST" action={{route('deleteUser', ['user' => $profile->user->id])}}>

                @csrf
                @method('DELETE')

                <label for="promptConfirm">Type to confirm: "DELETE ACCOUNT"</label>
                <input type="text" name="confirmPrompt" class="form-control" placeholder="Please type the above">

            </form>

            <x-slot name="modalFooter">

                <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteAccountForm').submit()"><i class="fa fa-trash"></i> CONFIRM</button>

            </x-slot>
        </x-modal>

        <x-modal id="ipInfo" modal-label="ipInfo" modal-title="IP Address Information for {{$ipInfo->ip ?? 'Unknown'}}" include-close-button="true">

            <h4 class="text-center">Search results</h3>

              @if (!isset($ipInfo->message))

                  <table class="table table-borderless">

                      <tbody>

                          <tr>
                            <th>Origin Country</th>
                            <td>{{$ipInfo->country_name ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>State/Province</th>
                            <td>{{$ipInfo->state_prov ?? 'None'}}</td>
                          </tr>

                          <tr>
                            <th>District (if any)</th>
                            <td>{{$ipInfo->district ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>City</th>
                            <td>{{$ipInfo->city ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>Zipcode</th>
                            <td>{{$ipInfo->zipcode ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>Coordinates</th>
                            <td>{{$ipInfo->latitude ?? 0}}, {{$ipInfo->longitude ?? 0}}</td>
                          </tr>

                          <tr>
                            <th>European?</th>
                            <td>{{($ipInfo->is_eu) ? 'Yes' : 'No'}}</td>
                          </tr>

                          <tr>
                            <th>ISP</th>
                            <td>{{$ipInfo->isp ?? 'N/A'}}</td>
                          </tr>


                          <tr>
                            <th>Organization (if any)</th>
                            <td>{{$ipInfo->organization ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>C. Type</th>
                            <td>{{$ipInfo->connection_type ?? 'N/A'}}</td>
                          </tr>

                          <tr>
                            <th>Timezone</th>
                            <td>{{$ipInfo->time_zone->name ?? 'N/A'}}</td>
                          </tr>

                      </tbody>

                  </table>

              @else
                <div class="alert alert-danger">

                    <i class="fas fa-exclamation-circle"></i> <b>This query returned no results</b>
                    <p>
                      {{$ipInfo->message}}
                    </p>

                </div>
              @endif

            <x-slot name="modalFooter"></x-slot>
        </x-modal>

        <x-modal id="editUser" modal-label="editUser" modal-title="Edit PII and Roles" include-close-button="true">

          <form id="updateUserForm" method="post" action="{{ route('updateUser', ['user' => $profile->user->id]) }}">
            @csrf
            @method('PATCH')

            <label for="email">Email address</label>
            <input id="email" type="text" name="email" class="form-control" required value="{{ $profile->user->email }}" />

            <label for="name">Name</label>
            <input id="name" type="text" name="name" class="form-control" required value="{{ $profile->user->name }}" />

            <label for="uuid">Mojang UUID</label>
            <input id="uuid" type="text" name="uuid" class="form-control" required value="{{ $profile->user->uuid }}" />
            <p class="text-muted text-sm">
              <i class="fas fa-exclamation-triangle"></i> Warning! This is a sensitive setting! Changing this could have unintended consequences!
            </p>

            <div class="form-group mt-3">

              <label>Roles</label>
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

              <button type="button" class="btn btn-warning" onclick="$('#updateUserForm').submit()"><i class="fa fa-exclamation-cicle"></i> Save changes</button>

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
                    <p class="text-muted">Member since {{$since}}</p>
                    @if (Auth::user()->hasRole('admin'))
                        <button type="button" class="btn btn-sm btn-info" onclick="$('#ipInfo').modal('show')">Lookup {{$profile->user->originalIP}}</button>
                    @endif

                    @if ($profile->user->is(Auth::user()))
                        <button type="button" class="btn btn-sm btn-warning" onclick="window.location.href='{{route('showProfileSettings')}}'"><i class="fas fa-pencil-alt"></i></button>
                    @elseif (Auth::user()->hasRole('admin') && $profile->user->isStaffMember())
                        <button type="button" class="btn btn-sm btn-danger" onclick="$('#terminateUser').modal('show')">Terminate Staff Member</button>
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
                            Account Management (Admin)
                        </a>
                    </h5>
                    <div id="collapse-collapsed" class="collapse" aria-labelledby="heading-collapsed">
                        <div class="card-body">

                            <div class="management-btn text-center">

                                @if (!$profile->user->isBanned())
                                    <button class="btn btn-danger mb-2" id="banAccountTrigger"><i class="fa fa-ban"></i> Ban Account</button><br>
                                @else
                                    <form method="post" action="{{route('unbanUser', ['user' => $profile->user->id])}}">

                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-warning mb-2"><i class="fa fa-check"></i> Unban</button>

                                    </form>
                                @endif
                                <button class="btn btn-danger mb-2" onclick="$('#deleteAccount').modal('show')"><i class="fas fa-trash-alt"></i> Delete Account</button><br>

                                <button class="btn btn-warning mb-2" onclick="$('#editUser').modal('show')"><i class="fas fa-pencil-alt"></i> Edit Account</button><br>
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
                    <a href="#" onclick="toastr.info('User\'s Discord tag: {{$discord}}')" class="pr-2 pl-2"><i class="fab fa-discord fa-2x"></i></a>
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
                <h4>About</h4>
            </div>

            <div class="card-body">

                {{$profile->profileAboutMe}}

            </div>

        </div>

        </div>


    </div>




@stop
