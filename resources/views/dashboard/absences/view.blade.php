@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Member absence review'))

@section('content_header')

    <h4>{{__('Human Resources')}} / {{ __('Staff') }} / {{__('View absence')}}</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('content')

    <div class="row">

        <div class="col">
            @csrf

            <div class="card card-secondary">

                <div class="card-header">
                    <h4 class="card-title">{{ __('Leave of absence') }}</h4>
                    <div class="card-tools">

                        @can('admin.manageAbsences')
                            @if (Auth::user()->is($absence->requester))
                                <span rel="spanTxtTooltip" class="badge-warning badge" data-toggle="tooltip" data-placement="top" title="{{ __('While you have the necessary permissions to manage all absence requests, you may not approve nor deny your own requests, however, you may still delete them.') }}"><i class="fas fa-exclamation-triangle"></i> {{ __('Your request') }}</span>
                            @endif
                        @endif

                        @switch($absence->status)
                            @case('Pending')
                                <span rel="spanTxtTooltip" data-toggle="tooltip" data-placement="top" title="{{ __('Waiting review by an admin') }}" class="badge badge-primary"><i class="fas fa-hourglass"></i> {{ $absence->status }}</span>
                                @break
                            @case('Approved')
                                <span rel="spanTxtTooltip" data-toggle="tooltip" data-placement="top" title="{{ __('Approved by an admin') }}" class="badge badge-success"><i class="fas fa-clipboard-check"></i> {{ $absence->status }}</span>
                                @break
                            @case('Declined')
                            @case('Cancelled')
                                <span rel="spanTxtTooltip" data-toggle="tooltip" data-placement="top" title="{{ __('Declined by an admin or withdrawn by the requester') }}" class="badge badge-danger"><i class="fas fa-ban"></i> {{ $absence->status }}</span>
                                @break
                            @case('Ended')
                                <span rel="spanTxtTooltip" data-toggle="tooltip" data-placement="top" title="{{ __('This request reached its predicted end date') }}" class="badge badge-warning"><i class="fas fa-calendar-check"></i> {{ $absence->status }}</span>
                                @break
                            @default
                                <span class="badge badge-danger"><i class="fas fa-bolt"></i> {{ __('Unavailable!') }}</span>

                        @endswitch
                    </div>
                </div>

                <div class="card-body">

                    <h3><i class="fas fa-info-circle"></i> {{ __('Request details') }}</h3>
                    <hr>

                    <label for="submittedDate"><i class="fas fa-paper-plane"></i> {{ __('Submitted at') }}</label>
                    <p id="submittedDate">{{ \Carbon\Carbon::parse($absence->created_at)->ago() }}</p>

                    <label for="timeframe"><i class="fas fa-calendar-alt"></i> {{__('Requested time period')}}</label>
                    <p id="timeframe">{{ $absence->start }} &mdash; {{ $absence->predicted_end }} {{ __('(:totalDays days)', ['totalDays' => $totalDays]) }}</p>

                    <label for="available"><i class="fas fa-user-cog"></i> {{ __('Available to chat?') }}</label>
                    @if($absence->available_assist == "1")
                        <span id="available" class="badge badge-success"><i class="fas fa-check"></i> {{ __('Available') }}</span>
                    @else
                        <span id="available" class="badge badge-warning"><i class="fas fa-user-slash"></i> {{ __('Not available') }}</span>
                    @endif

                    <p class="text-muted text-sm"><i class="fas fa-info-circle"></i> {{ __('This indicates whether the requesting user will be able to respond to emails, DMs, etc, during their absence.') }}</p>

                    <label for="reason"><i class="fas fa-clipboard"></i> {{ __('Request reason') }}</label>
                    <input type="text" class="form-control" disabled value="{{ $absence->reason }}">

                </div>

                <div class="card-footer text-center">
                    @can('admin.manageAbsences')

                        @if(!Auth::user()->is($absence->requester) && $absence->isActionable())
                            <form class="d-inline" name="approveRequestFrm" method="post" action="{{ route('approveAbsence', ['absence' => $absence->id]) }}">
                                @csrf
                                @method('PATCH')
                                <x-button id="approveRequestBtn" size="sm" type="submit" color="success" icon="fas fa-check-double">
                                    {{ __('Approve request') }}
                                </x-button>
                            </form>

                            <form class="d-inline" name="denyRequestFrm" method="post" action="{{ route('declineAbsence', ['absence' => $absence->id]) }}">
                                @csrf
                                @method('PATCH')
                                <x-button id="denyRequestBtn" size="sm" type="submit" color="danger" icon="fas fa-ban">
                                    {{ __('Deny request') }}
                                </x-button>
                            </form>

                        @endif

                        <form class="d-inline" name="deleteAbsence" method="post" action="{{ route('absences.destroy', ['absence' => $absence->id]) }}">
                            @csrf
                            @method('DELETE')
                            <x-button id="deleteRequestBtn" size="sm" type="submit" color="danger" icon="fas fa-trash">
                                {{ __('Delete request') }}
                            </x-button>
                        </form>
                    @endcan

                    @if (Auth::user()->is($absence->requester) && $absence->isActionable(true))
                        @can('reviewer.withdrawAbsence')
                                <form class="d-inline" name="cancelRequest" method="post" action="{{ route('cancelAbsence', ['absence' => $absence->id]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-button id="retractRequestBtn" size="sm" type="submit" color="warning" icon="fas fa-undo">
                                        {{ __('Retract request') }}
                                    </x-button>
                                </form>
                        @endcan
                    @endif

                </div>
            </div>
        </div>


        <div class="col">

            <div class="card card-widget widget-user">
                <div class="widget-user-header bg-secondary">
                    <h3 class="widget-user-username">{{ $absence->requester->name }} </h3>
                    <h5 class="widget-user-desc">{{ $absence->requester->email }}</h5>
                </div>
                <div class="widget-user-image">
                    @if($absence->requester->profile->avatarPreference == 'gravatar')
                        <img class="profile-user-img elevation-2 img-fluid img-circle" src="https://gravatar.com/avatar/{{md5($absence->requester->email)}}" alt="User profile picture">
                    @else
                        <img class="profile-user-img elevation-2 img-fluid img-circle" src="https://crafatar.com/avatars/{{$absence->requester->uuid}}" alt="User profile picture">
                    @endif


                </div>
                <div class="card-footer text-center">
                    @foreach ($absence->requester->roles as $role)
                        <span class="badge badge-secondary mr-2">{{ucfirst($role->name)}}</span>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <div class="row mt-3">
        <div class="col text-center">
            <x-button type="submit" id="backToAbsences" color="secondary" icon="fas fa-angle-double-left" link="{{ route('absences.index') }}">
                {{ __('Back to Absence list') }}
            </x-button>
        </div>
    </div>


@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
