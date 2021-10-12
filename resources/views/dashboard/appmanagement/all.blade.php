@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.application_m.all_apps'))

@section('content_header')

    <h4>{{__('messages.application_m.title')}} / {{__('messages.application_m.all_apps')}}</h4>

@stop

@section('js')

    <script type="text/javascript" src="/js/app.js"></script>
    <x-global-errors></x-global-errors>

@stop

@section('content')


  @foreach($applications as $application)

    <x-modal id="deletionConfirmationModal-{{ $application->id }}" modal-label="deletion-{{ $application->id }}" modal-title="{{__('messages.application_m.modal_confirm')}}" include-close-button="true">

      <h4><i class="fas fa-exclamation-triangle"></i> {{__('messages.application_m.really_delete')}}</h4>
      <p>
        {{__('messages.application_m.delete_action_warning', ['consequence' => '<b>' . __('messages.application_m.consequence_irreversible') .'</b>'])}}
      </p>
      <p>{{__('messages.application_m.delete_explainer')}}</p>

      <x-slot name="modalFooter">

        <form method="POST" action="{{ route('deleteApplication', ['application' => $application->id]) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger"><i class="fas fa-check-double"></i> {{__('messages.reusable.confirm_plain')}}</button>

        </form>

      </x-slot>

    </x-modal>

  @endforeach

  <div class="row">

    <div class="col">


        <div class="callout callout-info">

          <div class="row">


            <div class="col-3">

              <img src="/img/applications_all.svg" alt="Applications illustration" class="img-responsive" width="200px"/>

            </div>

            <div class="col">

              <h3><i class="fas fa-info-circle"></i> {{__('messages.application_m.all_apps_header')}}</h3>
              <p>
                {{__('messages.application_m.all_apps_exp')}}
              </p>

            </div>

          </div>

        </div>

    </div>

  </div>



  <div class="row mt-5">

    <div class="col">

      <div class="card">
        <!-- MAIN CONTENT - APPS AND PICS -->

        <div class="card-header">

          <div class="row">

            <div class="col">
              <h3>{{__('messages.application_m.all_apps')}}</h3>
            </div>

          </div>

        </div>

        <div class="card-body">


            <div class="row">

              <div class="col-3 center">

                <img src="/img/placeholders.svg" alt="Placeholder illustration" class="img-responsive" width="200px"/>

              </div>


              <div class="col">

                @if (!$applications->isEmpty())

                  <table class="table table-borderless" style="whitespace: nowrap">

                      <thead>

                        <tr>
                          <th>#</th>
                          <th>{{__('messages.application_m.applicant')}}</th>
                          <th>{{__('messages.reusable.status')}}</th>
                          <th>{{__('messages.reusable.date')}}</th>
                          <th>{{__('messages.reusable.actions')}}</th>
                        </tr>

                      </thead>

                      <tbody>

                        @foreach($applications as $application)

                          <tr>
                            <td>{{ $application->id }}</td>
                            <td><a href="{{ route('showSingleProfile', ['user' => $application->user->id]) }}">{{ $application->user->name }}</a></td>
                            <td>
                              @switch($application->applicationStatus)

                                @case('STAGE_SUBMITTED')

                                  <span class="badge badge-primary"><i class="far fa-clock"></i> {{__('messages.application_m.outstanding_subm')}}</span>
                                @break

                                @case('STAGE_PEERAPPROVAL')

                                  <span class="badge badge-warning"><i class="fas fa-vote-yea"></i> {{__('messages.application_m.p_review')}}</span>
                                @break

                                @case('STAGE_INTERVIEW')

                                  <span class="badge badge-warning"><i class="fas fa-microphone-alt"></i> {{__('messages.application_m.interview_p')}}</span>

                                @break

                                @case('STAGE_INTERVIEW_SCHEDULED')

                                  <span class="badge badge-warning"><i class="far fa-clock"></i>{{__('messages.application_m.interview_s')}}</span>

                                @break

                                @case('APPROVED')

                                  <span class="badge badge-success"><i class="fas fa-check"></i> {{__('messages.application_m.approved')}}</span>

                                @break

                                @case('DENIED')

                                  <span class="badge badge-danger"><i class="fas fa-times"></i> {{__('messages.application_m.denied')}}</span>

                                @break;

                                @default
                                  <span class="badge badge-secondary"><i class="fas fa-question-circle"></i> {{__('messages.application_m.denied')}}</span>


                              @endswitch
                            </td>
                            <td>{{ $application->created_at }}</td>
                            <td>
                              <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='{{ route('showUserApp', ['application' => $application->id]) }}'"><i class="fas fa-eye"></i> {{__('messages.reusable.view')}}</button>
                              <button type="button" class="btn btn-danger btn-sm ml-2" onclick="$('#deletionConfirmationModal-{{ $application->id }}').modal('show')"><i class="fa fa-trash"></i> {{__('messages.reusable.delete')}}</button>
                            </td>
                          </tr>

                        @endforeach

                      </tbody>

                  </table>

                @else

                  <div class="alert alert-warning">

                    <h3><i class="fas fa-question-circle"></i> {{__('messages.application_m.no_apps')}}</h3>
                    <p>
                      {{__('messages.application_m.no_apps_exp')}}
                    </p>

                  </div>

                @endif

              </div>

            </div>


        </div>

        <!-- end main content card -->
      </div>

       @if (!$applications->isEmpty() && isset($applications->links))

         <div class="card-footer">

           {{ $applications->links }}

         </div>

       @endif

    </div>

  </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
