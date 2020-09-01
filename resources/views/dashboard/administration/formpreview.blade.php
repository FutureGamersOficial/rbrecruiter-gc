@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.form_preview.title'))

@section('content_header')

    <h4>{{__('messages.adm')}} / {{__('messages.form_builder.builder')}} / {{__('messages.form_preview.preview')}}</h4>

@stop


@section('js')

  <x-global-errors></x-global-errors>

@stop


@section('content')

  <div class="row">

      <div class="col-6 offset-4">

        <img src="/img/preview.svg" width="250px" alt="Form preview illustration" />

      </div>

  </div>

  <div class="row mt-4">

    <div class="col">
      <div class="alert alert-success">

        <h5><i class="fas fa-eye"></i> {{__('messages.form_preview.looks')}}</h5>

        <p>
          {{__('messages.form_preview.f_info')}}
        </p>

      </div>
    </div>

  </div>

  <div class="row">

    <div class="col">

      <div class="card">

        <div class="card-header">

          <h3>{{ $title }} - {{__('messages.form')}}</h2>

        </div>

        <div class="card-body">

          @component('components.form', ['form' => $form, 'disableFields' => true])

          @endcomponent

        </div>

        <div class="card-footer text-center">

          <button type="button" class="btn btn-success ml-2" onclick="window.location.href='{{ route('showForms') }}'"><i class="fas fa-chevron-left"></i> {{__('messages.back')}}</button>
          <button type="button" class="btn btn-warning ml-2" onclick="window.location.href='{{ route('editForm', ['form' => $formID]) }}'"><i class="far fa-edit"></i> {{__('messages.edit')}}</button>
        </div>

      </div>

    </div>

  </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
