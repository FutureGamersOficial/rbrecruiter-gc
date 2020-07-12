@extends('adminlte::page')

@section('title', 'Raspberry Network | Profile')

@section('content_header')

    <h4>Application Management / All Applications</h4>

@stop

@section('js')

    <script type="text/javascript" src="/js/app.js"></script>
    <x-global-errors></x-global-errors>

@stop

@section('content')


  @foreach($applications as $application)

    <x-modal id="deletionConfirmationModal-{{ $application->id }}" modal-label="deletion-{{ $application->id }}" modal-title="Are you sure?" include-close-button="true">

      <h4><i class="fas fa-exclamation-triangle"></i> Really delete this?</h3>
      <p>
        This action is <b>IRREVERSBILE.</b>
      </p>
      <p>Comments, appointments and any votes attached to this application WILL be deleted too. Please make sure this application really needs to be deleted.</p>

      <x-slot name="modalFooter">

        <form method="POST" action="{{ route('deleteApplication', ['application' => $application->id]) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger"><i class="fas fa-check-double"></i> Confirm</button>

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

              <h3><i class="fas fa-info-circle"></i> You're looking at all applications ever received</h3>
              <p>
                Here, you have quick and easy access to all applications ever received by the system.
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

            <div class="col-3">
              <h3>All applications</h3>
            </div>

            <div class="col">

              <div class="navbtn right" style="whitespace: nowrap">

                <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('staffPendingApps') }}'"><i class="far fa-folder-open"></i> Outstanding Applications</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('pendingInterview') }}'"><i class="fas fa-microphone-alt"></i> Interview Queue</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('peerReview') }}'"><i class="fas fa-search"></i> Peer Review</button>

              </div>

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
                          <th>Applicant</th>
                          <th>Status</th>
                          <th>Date</th>
                          <th>Actions</th>
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

                                  <span class="badge badge-primary"><i class="far fa-clock"></i> Outstanding (Submitted)</span>
                                @break

                                @case('STAGE_PEERAPPROVAL')

                                  <span class="badge badge-warning"><i class="fas fa-vote-yea"></i> Peer Approval</span>
                                @break

                                @case('STAGE_INTERVIEW')

                                  <span class="badge badge-warning"><i class="fas fa-microphone-alt"></i> Interview</span>

                                @break

                                @case('STAGE_INTERVIEW_SCHEDULED')

                                  <span class="badge badge-warning"><i class="far fa-clock"></i>Interview Scheduled</span>

                                @break

                                @case('APPROVED')

                                  <span class="badge badge-success"><i class="fas fa-check"></i> Approved</span>

                                @break

                                @case('DENIED')

                                  <span class="badge badge-danger"><i class="fas fa-times"></i> Denied</span>

                                @break;

                                @default
                                  <span class="badge badge-secondary"><i class="fas fa-question-circle"></i> Unknown</span>


                              @endswitch
                            </td>
                            <td>{{ $application->created_at }}</td>
                            <td>
                              <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='{{ route('showUserApp', ['id' => $application->id]) }}'"><i class="fas fa-eye"></i> View</button>
                              <button type="button" class="btn btn-danger btn-sm ml-2" onclick="$('#deletionConfirmationModal-{{ $application->id }}').modal('show')"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                          </tr>

                        @endforeach

                      </tbody>

                  </table>

                @else

                  <div class="alert alert-warning">

                    <h3><i class="fas fa-question-circle"></i> There are no applications here</h3>
                    <p>
                      We couldn't find any applications. Maybe no one has applied yet?
                      Please try again later.
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
