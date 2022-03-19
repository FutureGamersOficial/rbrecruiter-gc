@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('All Applications'))

@section('content_header')

    <h4>{{__('Application Management')}} / {{__('All Applications')}}</h4>

@stop

@section('js')

    <script type="text/javascript" src="/js/app.js"></script>
    <x-global-errors></x-global-errors>

@stop

@section('content')


  @foreach($applications as $application)

    <x-modal id="deletionConfirmationModal-{{ $application->id }}" modal-label="deletion-{{ $application->id }}" modal-title="{{__('Are you sure?')}}" include-close-button="true">

      <h4><i class="fas fa-exclamation-triangle"></i> {{__('Really delete this?')}}</h4>
      <p>
        {!! __('This action is :consequence.', ['consequence' => '<b>' . __('IRREVERSIBLE.') .'</b>']) !!}
      </p>
      <p>{{__('Comments, appointments and any votes attached to this application WILL be deleted too. Please make sure this application really needs to be deleted.')}}</p>

      <x-slot name="modalFooter">

        <form method="POST" action="{{ route('deleteApplication', ['application' => $application->id]) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger"><i class="fas fa-check-double"></i> {{__('Confirm')}}</button>

        </form>

      </x-slot>

    </x-modal>

  @endforeach

  <div class="row">

    <div class="col">


        <div class="callout callout-info">

          <div class="row">


            <div class="col-3">

              <img src="/img/applications_all.svg" alt="{{ __('Applications illustration') }}" class="img-responsive" width="200px"/>

            </div>

            <div class="col">

              <h3><i class="fas fa-info-circle"></i> {{__("You're looking at all applications ever received")}}</h3>
              <p>
                {{__('Here, you have quick and easy access to all applications ever received by the system.')}}
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
              <h3>{{__('All Applications')}}</h3>
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
                          <th>{{__('Applicant')}}</th>
                          <th>{{__('Status')}}</th>
                          <th>{{__('Date')}}</th>
                          <th>{{__('Actions')}}</th>
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

                                  <span class="badge badge-primary"><i class="far fa-clock"></i> {{__('Outstanding (Submitted)')}}</span>
                                @break

                                @case('STAGE_PEERAPPROVAL')

                                  <span class="badge badge-warning"><i class="fas fa-vote-yea"></i> {{__('Peer Review')}}</span>
                                @break

                                @case('STAGE_INTERVIEW')

                                  <span class="badge badge-warning"><i class="fas fa-microphone-alt"></i> {{__('Interview')}}</span>

                                @break

                                @case('STAGE_INTERVIEW_SCHEDULED')

                                  <span class="badge badge-warning"><i class="far fa-clock"></i>{{__('Interview Scheduled')}}</span>

                                @break

                                @case('APPROVED')

                                  <span class="badge badge-success"><i class="fas fa-check"></i> {{__('Approved')}}</span>

                                @break

                                @case('DENIED')

                                  <span class="badge badge-danger"><i class="fas fa-times"></i> {{__('Denied')}}</span>

                                @break;

                                @default
                                  <span class="badge badge-secondary"><i class="fas fa-question-circle"></i> {{__('Denied')}}</span>


                              @endswitch
                            </td>
                            <td>{{ $application->created_at }}</td>
                            <td>
                              <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='{{ route('showUserApp', ['application' => $application->id]) }}'"><i class="fas fa-eye"></i> {{__('View')}}</button>
                              <button type="button" class="btn btn-danger btn-sm ml-2" onclick="$('#deletionConfirmationModal-{{ $application->id }}').modal('show')"><i class="fa fa-trash"></i> {{__('Delete')}}</button>
                            </td>
                          </tr>

                        @endforeach

                      </tbody>

                  </table>

                @else

                  <div class="alert alert-warning">

                    <h3><i class="fas fa-question-circle"></i> {{__('There are no applications here')}}</h3>
                    <p>
                      {{__("We couldn't find any applications. Maybe no one has applied yet? Please try again later.")}}
                    </p>

                  </div>

                @endif

              </div>

            </div>


        </div>

          @if (!$applications->isEmpty())

              <div class="card-footer">

                  {{ $applications->links() }}

              </div>

      @endif
        <!-- end main content card -->
      </div>



    </div>

  </div>

@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
