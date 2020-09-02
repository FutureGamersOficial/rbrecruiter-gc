@extends('adminlte::page')

@section('title',  config('app.name') . '| ' . __('messages.form_builder.builder_name'))

@section('content_header')

    <h4>{{__('messages.adm')}} / {{__('messages.form_builder.builder')}}</h4>

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

@stop

@section('content')

    <div class="row">

        <div class="col-md-5 offset-md-3">

            <div class="card">

                <div class="card-body">

                    <form id="formbuilder" action="{{route('saveForm')}}" method="POST">

                        @csrf

                        <fieldset id="buildyourform">
                            <legend class="text-center">{{__('messages.form_builder.builder')}}</legend>

                            <input type="text" name="formName" class="form-control mb-5" placeholder="{{__('messages.form_builder.name_form')}}" required>

                        </fieldset>

                    </form>

                </div>

                <div class="card-footer text-center">

                    <button onclick="save()" type="button" class="btn btn-success">{{__('messages.form_builder.save_form')}}</button>
                    <input type="button" value="{{__('messages.new_field')}}" class="add btn btn-info ml-3" id="add" />


                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
