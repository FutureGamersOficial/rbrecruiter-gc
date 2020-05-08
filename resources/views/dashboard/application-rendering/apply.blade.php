@extends('adminlte::page')

@section('title', 'Raspberry Network Team Management')

@section('content_header')
    <h1>My Account / Apply / {{$vacancy->vacancyName}} Application</h1>
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

@stop

@section('content')

    <div class="modal fade" tabindex="-1" id="confirm" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmLabel">Please confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p>Are you sure you want to submit your application? Please review each of your answers carefully before doing so.</p>
                    <p class="text-bold">Please note: Applications CANNOT be modified once they're submitted!</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="document.getElementById('submitApplicationForm').submit()"><i class="fas fa-check-double"></i> Accept & Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Review</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col">

            <div class="callout callout-success">

                <p class="text-bold">You are applying for: {{$vacancy->vacancyName}}</p>

                <p>We're glad you've decided to apply. Generally, applications take 48 hours to be processed and reviewed. Depending on the circumstances and the volume of applications, you may receive an answer in a shorter time.</p>
                <p>Please fill out the form below. Keep all answers concise and complete. Please keep in mind that the age requirement is <b>at least 18 years old</b>.</p>
                <p class="text-bold">Asking about your application will result in instant denial. Everything you need to know is here.</p>

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
                       @foreach($preprocessedForm['fields'] as $fieldName => $field)

                           @switch ($field['type'])

                               @case('textarea')

                               <div class="form-group mt-2 mb-2">

                                   <label for="{{$fieldName}}">{{$field['title']}}</label>
                                   <textarea class="form-control" rows="7" name="{{$fieldName}}" id="{{$fieldName}}">

                                     </textarea>

                               </div>

                               @break

                               @case('textbox')

                               <div class="form-group mt-2 mb-2">

                                   <label for="{{$fieldName}}">{{$field['title']}}</label>
                                   <input type="text" name="{{$fieldName}}" id="{{$fieldName}}" class="form-control">


                               </div>

                               @break

                           @endswitch

                       @endforeach

                   </form>

                </div>

                <div class="card-footer text-center">

                    <button type="button" class="btn btn-success" onclick="$('#confirm').modal('show')"><i class="fas fa-paper-plane"></i> Send</button>

                </div>

            </div>

        </div>

    </div>

@stop
