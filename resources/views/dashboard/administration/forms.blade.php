@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.forms_p.available_forms'))

@section('content_header')

    <h4>{{__('messages.adm')}} / {{__('messages.forms')}}</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="card bg-gray-dark">

                <div class="card-header bg-indigo">
                    <div class="card-title"><h4 class="text-bold">{{__('messages.forms_p.available_forms')}}</h4></div>
                </div>

                <div class="card-body">

                    @if(!$forms->isEmpty())

                        <table class="table table-active table-borderless" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>{{__('messages.forms_p.form_title')}}</th>
                                <th>{{__('messages.reusable.created_at')}}</th>
                                <th>{{__('messages.reusable.updated_at')}}</th>
                                <th>{{__('messages.reusable.actions')}}</th>
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
                                        <form  style="display: inline-block; white-space: nowrap" action="{{route('destroyForm', ['form' => $form->id])}}" method="POST">

                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-danger mr-2"><i class="fa fa-trash"></i> {{__('messages.reusable.delete')}}</button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='{{ route('previewForm', ['form' => $form->id]) }}'"><i class="fa fa-eye"></i> {{__('messages.form_preview.preview')}}</button>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="alert alert-warning">

                            {{__('messages.forms_p.empty_noforms')}}

                        </div>

                    @endif

                </div>

                <div class="card-footer">

                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route('showFormBuilder')}}'">{{__('messages.forms_p.new_form')}}</button>

                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
