@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Member absence request'))

@section('content_header')

    <h4>{{__('Human Resources')}} / {{ __('Staff') }} / {{__('Absence request')}}</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

    <script>
        $('#startDate').flatpickr(
            {
                enableTime: false,
                dateFormat: 'Y-m-d',
                static: false
            }
        )
        $('#predictedEnd').flatpickr(
            {
                enableTime: false,
                dateFormat: 'Y-m-d',
                static: false
            }
        )
    </script>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <form name="submitAbsenceRequest" method="post" action="{{ route('absences.store') }}">
                @csrf

                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">{{ __('Leave of absence') }}</h4>
                    </div>

                    <div class="card-body">

                        @if ($activeRequest)
                            <x-alert alert-type="danger" icon="fa-exclamation-triangle" title="{{ __('Submissions locked!') }}">
                                {{ __('Sorry, but you already have an active leave of absence request. Please cancel (or let expire) your previous request before attempting to make a new one.') }}
                            </x-alert>
                        @endif

                        <div class="form-group">
                            <label for="reason"><i class="fas fa-clipboard"></i> {{ __('Request reason') }}</label>
                            <input {{ ($activeRequest) ? 'disabled' : '' }} id="reason" name="reason" type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="start_date"><i class="far fa-clock"></i> {{ __('Absence start date') }}</label>
                                    <input {{ ($activeRequest) ? 'disabled' : '' }} type="text" name="start_date" id="startDate" class="form-control" required>
                                </div>

                                <div class="col">
                                    <label for="predicted_end"><i class="fas fa-history"></i> {{ __('Predicted end') }}</label>
                                    <input {{ ($activeRequest) ? 'disabled' : '' }} type="text" name="predicted_end" id="predictedEnd" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <input type="hidden" name="available_assist" value="off">
                            <label><input {{ ($activeRequest) ? 'disabled' : '' }} type="checkbox" name="available_assist"> {{ __('Will you be available to assist occasionally during your absence?') }}</label>

                            <input type="hidden" name="invalidAbsenceAgreement" value="off">
                            <label><input {{ ($activeRequest) ? 'disabled' : '' }} type="checkbox" name="invalidAbsenceAgreement"> {{ __('I understand that inactivity/no-show after a declined/expired absence request will be treated according to standard procedure.') }}</label>
                        </div>
                    </div>

                    <div class="card-footer">
                        <x-button disabled="{{ (bool) $activeRequest }}" id="btnSubmitRequest" type="submit" color="success" icon="fas fa-paper-plane">
                            {{ __('Submit for approval') }}
                        </x-button>
                    </div>

                </div>
            </form>

        </div>


        <div class="col">
            <div class="card">
                <div class="card-body">
                    <x-alert alert-type="info" title="{{ __('How to request a leave of absence') }}" icon="fa-info-circle">

                        <p>{{ __('A leave of absence allows you to step away from your duties for a period of time. To request one, simply fill the form to your left, and enter the reason for which you\'re stepping away. You will also need to specify when you will be unavailable, and when you predict to be back.') }}</p
                        <p>{{ __('You will also need to agree to the terms of a LOA. Additionally, you may also specify whether you\'ll be available to chat occasionally during your absence, but not perform your full duties.') }}</p>
                        <p>{{ __('You may only have one active request at the same time, which will have to be either approved or declined by the admins. Please keep in mind that you will not be able to delete any of your requests.') }}</p>
                    </x-alert>
                </div>

                <div class="card-footer">
                    <x-button id="btnCancelRequest" color="info" icon="fas fa-info-circle">
                        {{ __('Cancel request') }}
                    </x-button>
                </div>
            </div>
        </div>

    </div>


@stop
