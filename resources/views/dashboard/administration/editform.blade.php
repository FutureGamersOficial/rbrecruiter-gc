@extends('adminlte::page')

@section('title', 'Raspberry Network | Edit From')

@section('content_header')

    <h4>Administration / Forms / Editor</h4>

@stop

@section('js')

  <script src="/js/formeditor.js"></script>
  <x-global-errors></x-global-errors>

@stop

@section('content')

  <div class="row mb-5">
    <div class="col">

    </div>
    <div class="col text-center">

      <img src="/img/editor.svg" width="250px" alt="Editor illustration" class="img-responsive" />

    </div>
    <div class="col">

    </div>
  </div>


  <div class="row">

    <div class="col">


    </div>
    <div class="col">

      <form id="editForm" method="POST" action="{{ route('updateForm', ['form' => $formID]) }}">
        @csrf
        @method('PATCH')
          <div class="card">

            <div class="card-header">

              <h4>Editing {{ $title }}...</h4>

            </div>

            <div class="card-body">

              @foreach($formStructure['fields'] as $fieldName => $field)

                <div class="form-group mt-4 mb-4">

                    <input autocomplete="false" type="text" id="{{ $fieldName }}" class="form-control" name="{{ $fieldName }}[]" value="{{ $field['title'] }}" />

                    <select class="custom-select" id="{{ $fieldName }}-type" name="{{ $fieldName }}[]">

                        <option value="nil" disabled>Choose a type</option>
                        <option value="textbox" {{ ($field['type'] == 'textbox' ? 'selected' : '') }}>Textbox</option>
                        <option value="textarea" {{ ($field['type'] == 'textarea' ? 'selected' : '') }}>Multi line answer</option>
                        <option value="checkbox" {{ ($field['type'] == 'checkbox' ? 'selected' : '') }}>Checkbox</option>

                    </select>

                </div>

              @endforeach

              <div class="field-container mt-4 mb-4">



              </div>

            </div>

            <div class="card-footer text-center">

              <button type="button" class="btn btn-warning ml-2" onclick="$('#editForm').submit()"><i class="fas fa-save"></i> Save & Quit</button>
              <button type="button" class="btn btn-primary ml-2" id="add"><i class="fas fa-plus"></i> New field</button>

            </div>


          </div>

      </form>

    </div>

    <div class="col">

    </div>

  </div>

@stop
