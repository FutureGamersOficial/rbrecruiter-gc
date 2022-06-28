@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Account Management'))

@section('content_header')

    <h4>{{ __('Users / Accounts / :username / Manage', ['username' => $user->name]) }}</h4>

@stop

@section('js')
    <script src="/js/app.js"></script>
    <x-global-errors></x-global-errors>
@stop

@section('content')

    <x-modal id="banAccountModal" modal-label="banAccount" modal-title="{{__('Please confirm')}}" include-close-button="true">

        <p>{{__("Please confirm that you want to suspend this account. You'll need to add a reason and expiration date to confirm this.")}}</p>

        <form id="banAccountForm" name="banAccount" method="POST" action="{{route('banUser', ['user' => $user->id])}}">
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

    @if (!Auth::user()->is($user) && $user->isStaffMember())
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

                <form method="POST" action="{{route('terminateStaffMember', ['user' => $user->id])}}" id="terminateUserForm">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning" {{ ($demoActive) ? 'disabled' : '' }}><i class="fas fa-exclamation-circle"></i> {{__('Confirm')}}</button>

                </form>

            </x-slot>

        </x-modal>
    @endif

    <x-modal id="deleteAccount" modal-label="deleteAccount" modal-title="{{__('Confirm')}}" include-close-button="true">

        @if($demoActive)
            <div class="alert alert-danger">
                <p class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
            </div>
        @endif

        <p><i class="fa fa-exclamation-triangle"></i><b> {{__('WARNING: This is a potentially destructive action!')}}</b></p>

        <p>{{__("Deleting a user's account is an irreversible process. Historic and current applications, votes, and profile content, as well as any personally identifiable information will be immediately erased.")}}</p>

        <form id="deleteAccountForm" method="POST" action={{route('deleteUser', ['user' => $user->id])}}>

            @csrf
            @method('DELETE')

            <label for="promptConfirm">{{__('Type to confirm: ')}} "DELETE ACCOUNT"</label>
            <input type="text" name="confirmPrompt" class="form-control" placeholder="{{__('Please type the above text')}}">

        </form>

        <x-slot name="modalFooter">

            <button type="button" class="btn btn-danger" {{ ($demoActive) ? 'disabled' : '' }} onclick="document.getElementById('deleteAccountForm').submit()"><i class="fa fa-trash"></i> {{strtoupper(__('Confirm'))}}</button>

        </x-slot>
    </x-modal>


    <x-modal id="editUser" modal-label="editUser" modal-title="{{__('Edit account')}}" include-close-button="true">

        @if($demoActive)
            <div class="alert alert-danger">
                <p class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> {{ __('This feature is disabled') }}</p>
            </div>
        @endif

        <form id="updateUserForm" method="post" action="{{ route('updateUser', ['user' => $user->id]) }}">
            @csrf
            @method('PATCH')

            <label for="email">{{__('Email')}}</label>
            <input {{ ($demoActive) ? 'disabled' : '' }} id="email" type="text" name="email" class="form-control" required value="{{ $user->email }}" />

            <label for="name">{{__('Name')}}</label>
            <input {{ ($demoActive) ? 'disabled' : '' }} id="name" type="text" name="name" class="form-control" required value="{{ $user->name }}" />

            <label for="uuid">{{ __('Mojang UUID (deprecated)') }}</label>
            <input {{ ($demoActive) ? 'disabled' : '' }} id="uuid" type="text" name="uuid" class="form-control" required value="{{ $user->uuid ?? "disabled" }}" />
            <p class="text-muted text-sm">
                <i class="fas fa-exclamation-triangle"></i> {{__('If the setting "Require Valid Game License" is activated, editing this field may have unintended consequences. Proceed with caution.')}}
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


    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-header">
                    <h3>{{ __('Account data') }}</h3>
                </div>

                <div class="row">

                    <div class="col">



                    </div>

                </div>

            </div>

        </div>

    </div>

@stop


@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
