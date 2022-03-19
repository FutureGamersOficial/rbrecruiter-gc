@extends('adminlte::page')

@section('title',  config('app.name') . ' | ' . __('Application form management tool'))

@section('content_header')

    <h4>{{__('Administration')}} / {{__('Form builder')}}</h4>

@stop

@section('js')

    @if (session()->has('success'))

        <script>
            toastr.success("{{session('success')}}")
        </script>

    @elseif(session()->has('error'))

        @foreach(session('error') as $error)

            <script>
                toastr.error("{{session('error')}}")
            </script>

        @endforeach

    @endif

    @if(session()->has('exception'))
        <script>
            toastr.error("{{session('exception')}}")
        </script>
    @endif

    <script>
        $(document).ready(function () {

            $("#formName").keyup(function(){
                if($(this).val().length > 10){
                    $(window).bind('beforeunload', function(){
                        return "{{ __('Are you sure you want to leave the form builder? You have unsaved work.') }}";
                    });
                }
            });

            $(document).on("submit", "form", function(event){
                $(window).off('beforeunload');
            });
        })
    </script>

@stop

@section('content')

    <div class="row">

        <div class="col-md-5 offset-md-3">

            <div class="card">

                <div class="card-body">

                    <form id="formbuilder" action="{{route('saveForm')}}" method="POST">

                        @csrf

                        <fieldset id="buildyourform">
                            <legend class="text-center">{{__('Form builder')}}</legend>

                            <input type="text" name="formName" id="formName" class="form-control mb-5" placeholder="{{__('Name your form...')}}" required>

                        </fieldset>

                    </form>

                </div>

                <div class="card-footer text-center">

                    <button onclick="save()" type="button" class="btn btn-success">{{__('Save form')}}</button>
                    <input type="button" value="{{__('Add field')}}" class="add btn btn-info ml-3" id="add" />


                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
