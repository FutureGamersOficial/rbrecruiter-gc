@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <h1>{{config('app.name')}} / {{__('messages.dashboard')}}</h1>
@stop

@section('js')

  <script src="js/dashboard.js"></script>

@endsection

@section('content')

    @if (!$vacancies->isEmpty())

      @foreach($vacancies as $vacancy)

          <x-modal id="{{ $vacancy->vacancySlug . '-details' }}" modal-label="{{ $vacancy->vacancySlug . '-details-label' }}" modal-title="{{__('messages.details_m_title')}}" include-close-button="true">

            @if (is_null($vacancy->vacancyFullDescription))

              <div class="alert alert-warning">

                <h3><i class="fas fa-question-circle"></i> {{__('messages.opening_nodetails')}}</h3>
                <p>
                  {{__('messages.opening_nodetails_exp')}}
                </p>

              </div>
            @else

              {!! $vacancy->vacancyFullDescription !!}
              <p class="text-sm text-muted">
                {{__('messages.last_updated')}} @ {{ $vacancy->updated_at }}
              </p>
            @endif

            <x-slot name="modalFooter"></x-slot>

          </x-modal>

      @endforeach

    @endif

    <div class="row mt-5">

      <div class="col">

          <div class="text-center">

              <h4>{{__('messages.welcome_back')}} {{ Auth::user()->name }}!</h4>

          </div>

      </div>


    </div>


    <div class="row mb-3">

        <div class="col">
            <div class="alert alert-info">
                <p>{{__('messages.eligibility_status', ['badgeStatus' => '<span class="badge badge-warning"> ' . ($isEligibleForApplication) ? __('messages.eligible') : __('messages.ineligible') .'</span>'])}}</p>
            </div>
        </div>

    </div>


    @if (!Auth::user()->isStaffMember())

      <div class="row">
            <div class="col-lg-3 col-3 offset-3">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ $openApplications ?? 0 }}</h3>

                  <p>{{__('messages.ongoing_apps')}}</p>
                </div>
                <div class="icon">
                  <i class="fas fa-sync"></i>
                </div>
                <a href="{{ route('showUserApps') }}" class="small-box-footer">{{__('messages.open')}} <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{ $deniedApplications ?? 0 }}</h3>

                  <p>{{__('messages.denied_apps')}}</p>
                </div>
                <div class="icon">
                  <i class="fas fa-times"></i>
                </div>
                <a href="{{ route('showUserApps') }}" class="small-box-footer">{{__('messages.open')}} <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
        </div>

    @else

      <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $totalUserCount }}</h3>

                <p>{{__('messages.users_staff')}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              @if (Auth::user()->hasRole('admin'))

                <a href="{{ route('registeredPlayerList') }}" class="small-box-footer">{{__('messages.open')}} <i class="fas fa-arrow-circle-right"></i></a>

              @endif
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $totalDenied }}</h3>

                <p>{{__('messages.denied_apps')}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-slash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $totalNewApplications }}</h3>

                <p>{{__('messages.new_apps')}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-plus"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $totalPeerReview }}</h3>

                <p>{{__('messages.v_backlog')}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-vote-yea"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>

    @endif


      @if ($isEligibleForApplication && !Auth::user()->isStaffMember())
        <div class="row mt-5 mb-5">

            <div class="col text-center">

              <h4>{{__('messages.ranks')}}</h4>
              <hr />

            </div>

        </div>
      @endif

      <div class="row">

        @if (!$vacancies->isEmpty() && $isEligibleForApplication && !Auth::user()->isStaffMember())


          @foreach($vacancies as $vacancy)


              <div class="col{{ ($vacancy->count() == 1) ? '-3 offset-3' : '' }}">

                <div class="card card-outline card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{ $vacancy->vacancyName }}</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                  {{$vacancy->vacancyDescription}}
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-center">

                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('renderApplicationForm', ['vacancySlug' => $vacancy->vacancySlug]) }}'">{{__('messages.txt_apply')}}</button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="$('#{{ $vacancy->vacancySlug }}-details').modal('show')">{{__('messages.txt_learn_more')}}</button>

                </div>
              </div>

              </div>

          @endforeach

        @endif

      </div>


      <div class="row mt-4">

        <div class="col">

            <div class="card">

                <div class="card-header">

                    <h4>
                      <i class="fa fa-calendar"></i>&nbsp;&nbsp;{{__('messages.upcoming')}} (<i>{{__('messages.soon')}}</i>)
                    </h4>

                </div>

                <div class="card-body">

                    <div id="upcomingCalendar"></div>

                </div>

            </div>

        </div>

      </div>
@stop
@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
