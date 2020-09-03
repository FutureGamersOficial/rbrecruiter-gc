@extends('adminlte::page')

@section('title', 'Raspberry Network | Edit Positions')

@section('content_header')

    <h4>{{__('messages.adm')}} / {{__('messages.positions')}} / {{__('messages.edit')}}</h4>

@stop

@section('js')

  <x-global-errors>

  </x-global-errors>

@stop


@section('content')


  <div class="row">

    <div class="col center">

        <h3>{{__('messages.vacancy_edit')}}</h3>

    </div>

  </div>


  <div class="row">


    <div class="col">


      <div class="card">


        <div class="card-header">

            <h3 class="card-title"><i class="fas fa-clipboard"></i> {{ $vacancy->vacancyName }}</h3>

        </div>


        <div class="card-body">

          <p class="text-muted"><i class="fas fa-question-circle"></i> {{__('messages.form_consistency')}}</p>

          <form method="POST" id="editPositionForm" action="{{ route('updatePosition', ['vacancy' => $vacancy->id]) }}">

            @csrf
            @method('PATCH')

            <div class="row">

              <div class="col">


                <label for="vacancyName">{{__('messages.vacancy.name')}}</label>
                <input type="text" value="{{ $vacancy->vacancyName }}" class="form-control" disabled />

              </div>

              <div class="col">

                <label for="vacancyDescription">{{__('messages.vacancy.description')}}</label>
                <input type="vacancyDescription" class="form-control" name="vacancyDescription" value="{{ $vacancy->vacancyDescription }}" />


              </div>

            </div>

            <div class="row">

              <div class="col">

                <!-- skipping the accessor for obvious reasons -->
                <label for="vacanyDetails">{{__('messages.vacancy.details')}}</label>
                <textarea name="vacancyFullDescription" class="form-control" placeholder="{{ (is_null($vacancy->vacancyFullDescription)) ? __('messages.vacancy.no_details') : '' }}" rows="20">{{ $vacancy->getAttributes()['vacancyFullDescription'] }}</textarea>
                <span class="text-muted"><i class="fab fa-markdown"></i> {{__('messages.vacancy.markdown')}}</span>

              </div>

            </div>

            <div class="row">

              <div class="col">

                <label for="permissionGroupName">{{__('messages.vacancy.permission_group')}}</label>
                <input type="text" class="form-control" value="{{ $vacancy->permissionGroupName }}" id="permissionGroupName" disabled />

              </div>

              <div class="col">

                <label for="discordRoleID">{{__('messages.vacancy.discord_roleid')}}</label>
                <input type="text" class="form-control" value="{{ $vacancy->discordRoleID }}" id="discordRoleID" disabled />


              </div>
            </div>

            <div class="row">

              <div class="col">

                <label for="currentForm">{{__('messages.vacancy.current_form')}}</label>
                <input type="text" class="form-control" value="{{ $vacancy->forms->formName }}" id="currentForm" disabled />

                <label for="remainingSlots">{{__('messages.vacancy.remaining_slots')}}</label>
                <input type="text" class="form-control" value="{{ $vacancy->vacancyCount }}" id="remainingSlots" name="vacancyCount" />


              </div>

            </div>

          </form>

        </div>

        <div class="card-footer">

          <button type="button" class="btn btn-warning" onclick="$('#editPositionForm').submit()"><i class="fas fa-edit"></i> {{__('messages.vacancy.save')}}</button>
          <button type="button" class="btn btn-danger" onclick="window.location.href='{{ route('showPositions') }}'"><i class="fas fa-times"></i> {{__('messages.vacancy.cancel')}}</button>

          @if($vacancy->vacancyStatus == 'OPEN')

            <form method="POST" action="{{ route('updatePositionAvailability', ['vacancy' => $vacancy->id, 'status' => 'close']) }}" style="display: inline">
              @method('PATCH')
              @csrf
              <button type="submit" class="ml-4 btn btn-danger"><i class="fas fa-ban"></i> {{__('messages.vacancy.close_vacancy')}}</button>
            </form>

          @endif

        </div>


      </div>


    </div>

  </div>


@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
