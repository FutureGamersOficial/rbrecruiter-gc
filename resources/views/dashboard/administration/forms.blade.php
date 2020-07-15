@extends('adminlte::page')

@section('title', 'Raspberry Network | Application Form Management Tool')

@section('content_header')

    <h4>Administration / Forms</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="card bg-gray-dark">

                <div class="card-header bg-indigo">
                    <div class="card-title"><h4 class="text-bold">Available Forms</h4></div>
                </div>

                <div class="card-body">

                    @if(!$forms->isEmpty())

                        <table class="table table-active table-borderless" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>Form Title</th>
                                <th>Created On</th>
                                <th>Updated On</th>
                                <th>Actions</th>
                            </tr>

                            </thead>

                            <tbody>

                            @foreach($forms as $form)

                                <tr>
                                    <td>{{$form->id}}</td>
                                    <td>{{$form->formName}}</td>
                                    <td>{{$form->created_at}}</td>
                                    <td>{{ $form->updated_at }}</td>
                                    <td>
                                        <form  style="display: inline-block; white-space: nowrap" action="{{route('destroyForm', ['id' => $form->id])}}" method="POST">

                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-danger mr-2"><i class="fa fa-trash"></i> Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='{{ route('previewForm', ['form' => $form->id]) }}'"><i class="fa fa-eye"></i> Preview</button>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="alert alert-warning">

                            Nothing to see here! Please add some forms first.

                        </div>

                    @endif

                </div>

                <div class="card-footer">

                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route('showFormBuilder')}}'">NEW FORM</button>

                </div>

            </div>

        </div>

    </div>

@stop
