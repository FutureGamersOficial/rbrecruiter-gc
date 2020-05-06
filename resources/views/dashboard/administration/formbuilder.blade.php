@extends('adminlte::page')

@section('title', 'Raspberry Network | Application Form Management Tool')

@section('content_header')

    <h4>Administration / Form Builder</h4>

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
                            <legend class="text-center">Form Builder</legend>

                            <input type="text" name="formName" class="form-control mb-5" placeholder="Name your form..." required>

                        </fieldset>

                    </form>

                </div>

                <div class="card-footer text-center">

                    <button onclick="save()" type="button" class="btn btn-success">Save Form</button>
                    <input type="button" value="New Field" class="add btn btn-info ml-3" id="add" />


                </div>

            </div>

        </div>

    </div>

@stop
