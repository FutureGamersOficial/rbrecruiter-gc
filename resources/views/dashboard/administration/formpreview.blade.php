@extends('adminlte::page')

@section('title', 'Raspberry Network | Application Form Preview')

@section('content_header')

    <h4>Administration / Form Builder / Preview</h4>

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

        <h5><i class="fas fa-eye"></i> This is how your form looks like to applicants</h3>

        <p>
          You may edit it and add more fields later.
        </p>

      </div>
    </div>

  </div>

  <div class="row">

    <div class="col">

      <div class="card">

        <div class="card-header">

          <h3>{{ $title }}'s form</h2>

        </div>

        <div class="card-body">

          @component('components.form', ['form' => $form, 'disableFields' => true])

          @endcomponent

        </div>

        <div class="card-footer text-center">

          <button type="button" class="btn btn-success ml-2" onlick="window.location.href='{{ route('showForms') }}'"><i class="fas fa-chevron-left"></i> Go back</button>
          <button type="button" class="btn btn-warning ml-2"><i class="far fa-edit"></i> Edit</button>
        </div>

      </div>

    </div>

  </div>

@stop
