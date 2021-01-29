@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.txt_apply'))

@section('content_header')
    <h1>{{__('messages.reusable.my_acc')}} / {{__('messages.txt_apply')}} / {{$vacancy->vacancyName}} {{__('messages.txt_application')}}</h1>
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

        <script>toastr.error("{{__('messages.reusable.no_access')}}")</script>

    @endif

@stop

@section('content')

    @if($isEligibleForApplication)

        <div class="modal fade" tabindex="-1" id="confirm" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmLabel">{{__('messages.reusable.confirm')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <p>{{__('messages.application_r.appl_submit_warn')}}</p>
                        <p class="text-bold">{{__('messages.application_r.appl_submit_doublewarn')}}</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="document.getElementById('submitApplicationForm').submit()"><i class="fas fa-check-double"></i> {{__('messages.application_r.acceptsend')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.application_r.review')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col">

                <div class="callout callout-success">

                    <p class="text-bold">{{__('messages.application_r.applying_for', ['name' => $vacancy->vacancyName])}}</p>

                    <p>{{__('messages.application_r.welcome.line1')}}</p>
                    <p>{{__('messages.application_r.welcome.line2', ['agerqr' => '18 ' . __('messages.application_r.welcome.yrs_old')])}}.</p>
                    <p class="text-bold">{{__('messages.application_r.welcome.line3')}}.</p>

                    <p><i class="fab fa-markdown"></i> All fields support <a target="_blank" href="https://www.markdownguide.org/cheat-sheet/">Markdown</a></p>

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

                        <button type="button" class="btn btn-success" onclick="$('#confirm').modal('show')"><i class="fas fa-paper-plane"></i> {{__('messages.contactlabel_send')}}</button>

                    </div>

                </div>

            </div>

        </div>

    @else

        <div class="alert alert-danger">

            <p class="text-bold">{{__('messages.reusable.no_access')}}</p>

            <p>{{__('messages.application_r.app_timeout', ['days' => $eligibilityDaysRemaining])}}</p>
        </div>

    @endif

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
