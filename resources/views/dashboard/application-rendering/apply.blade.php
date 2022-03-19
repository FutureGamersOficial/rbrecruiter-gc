@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Apply'))

@section('content_header')
    <h1>{{__('My account')}} / {{__('Apply')}} / {{$vacancy->vacancyName}} {{__('Application')}}</h1>
@stop

@section('js')

    @if (session()->has('success'))

        <script>
            toastr.success("{{session('success')}}")
        </script>

    @elseif(session()->has('error'))

        <script>
            toastr.error("{{session('error')}}")
        </script>

    @endif

    @if(!$isEligibleForApplication)

        <script>toastr.error("{{__('Application access denied')}}")</script>

    @endif

@stop

@section('content')

    @if($isEligibleForApplication)

        <div class="modal fade" tabindex="-1" id="confirm" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmLabel">{{__('Please confirm')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <p>{{__('Are you sure you want to submit your application? Please review each of your answers carefully before doing so.')}}</p>
                        <p class="text-bold">{{__("Please note: Applications CANNOT be modified once they're submitted!")}}</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="document.getElementById('submitApplicationForm').submit()"><i class="fas fa-check-double"></i> {{__('Accept & Send')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Review')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col">
                <div class="alert alert-light">

                    {!! $vacancy->vacancyFullDescription !!}

                </div>
            </div>

        </div>

        <div class="row">

            <div class="col">

                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="text-bold">{{__('You are applying for: :vacancyNameValue', ['vacancyNameValue' => $vacancy->vacancyName])}}</p>

                    <p>{{__("We're glad you've decided to apply. Generally, applications take 48 hours to be processed and reviewed. Depending on the circumstances and the volume of applications, you may receive an answer in a shorter time.")}}</p>
                    <p>{{__('Please fill out the form below. Keep all answers concise and complete. Please keep in mind that the age requirement is at least :ageUpperLimitSettingValue years old.', ['ageUpperLimitSettingValue' => '16']) }}.</p>
                    <p class="text-bold">{{__('Asking about your application will result in instant denial. Everything you need to know is here.')}}.</p>

                    <p><i class="fab fa-markdown"></i> {!! __('All fields support <a target="_blank" href="https://www.markdownguide.org/cheat-sheet/">Markdown</a>') !!}</p>

                </div>

            </div>

        </div>


        <div class="row">

            <div class="col">


                <div class="card">

                    <div class="card-header">

                        <div class="card-title"><h4>{{$vacancy->forms->formName}}</h4></div>

                    </div>

                    <div class="card-body">

                        <form action="{{route('saveApplicationForm', ['vacancySlug' => $vacancy->vacancySlug])}}" method="POST" id="submitApplicationForm">
                            @csrf

                            @component('components.form', ['form' => $preprocessedForm, 'disableFields' => false])

                            @endcomponent

                        </form>

                    </div>

                    <div class="card-footer text-center">

                        <button type="button" class="btn btn-success" onclick="$('#confirm').modal('show')"><i class="fas fa-paper-plane"></i> {{__('Send')}}</button>

                    </div>

                </div>

            </div>

        </div>

    @else

        <div class="alert alert-danger">

            <p class="text-bold">{{__('Access denied')}}</p>

            <p>{{__('Your account is not permitted to submit another application. Please wait :applicationThrottleLimitSettingValue more days before trying to submit an application.', [':applicationThrottleLimitSettingValue' => $eligibilityDaysRemaining])}}</p>
        </div>

    @endif

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
