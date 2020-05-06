@extends('adminlte::page')

@section('title', 'Raspberry Network | Application Form Management Tool')

@section('content_header')

    <h4>Administration / Form Builder</h4>

@stop

@section('content')

    <div class="row">

        <div class="col-md-5 offset-md-3">

            <div class="card">

                <div class="card-body">

                    <form id="formbuilder" action="{{route('saveForm')}}" method="POST">

                        @csrf

                        <fieldset id="buildyourform">
                            <legend>Form Builder</legend>
                        </fieldset>

                    </form>

                    <div class="mt-4">
                        <input type="button" value="New Field" class="add btn btn-success" id="add" />
                    </div>


                </div>

                <div class="card-footer text-center">

                    <button onclick="save()" type="button" class="btn btn-success">Save Form</button>

                </div>

            </div>

        </div>

    </div>

@stop
