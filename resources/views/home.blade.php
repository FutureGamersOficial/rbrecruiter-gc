@extends('breadcrumbs.app')

@section('content')



	@if(!$positions->isEmpty())

		<!-- todo: details component -->

		@foreach($positions as $position)
				<x-modal id="{{ $position->vacancySlug . '-details' }}" modal-label="{{ $position->vacancySlug . '-details-label' }}" modal-title="{{__('Vacancy details')}}" include-close-button="true">

					@if (is_null($position->vacancyFullDescription))

						<div class="alert alert-warning">

							<h3><i class="fas fa-question-circle"></i> {{__("There don't seem to be any details.")}}</h3>
							<p>
								{{__('This vacancy does not have any details yet.')}}
							</p>

						</div>
					@else

						{!! $position->vacancyFullDescription !!}
						<p class="text-sm text-muted">
							{{__('Last updated @ :lastUpdatedTimeValue', [':lastUpdatedTimeValue' => $position->updated_at])}}
						</p>
					@endif

					<x-slot name="modalFooter"></x-slot>

				</x-modal>

		@endforeach


	@endif

	<!--Main Layout-->
	<main class="py-5">

	  <div class="container-fluid">

          @if ($demoActive)
              <div class="row">
                  <div class="col">
                      <div class="alert alert-warning">
                          <p class="font-weight-bold"><i class="fas fa-exclamation-circle"></i> {{ __('Attention') }}</p>
                          <p>{{ __('Demo mode is active on this instance. The database is refreshed daily and some features are disabled for security reasons.') }}</p>

                          <p>{{ __("If you're seeing this message in error, please contact your system administrator.") }}</p>
                      </div>
                  </div>
              </div>
          @endif


          <div class="row mt-5">

              <div class="col text-center">
                  <h3>Confira os cargos disponíveis</h3>
                  <p>Quer colaborar com a equipe da Games Club? Estamos recrutando! Confira um dos nossos cargos abertos. Uma boa equipe é um pilar de uma comunidade bem-sucedida.</p>
              </div>

          </div>

          <div class="row mt-5 mb-5">

              @if (!$positions->isEmpty())

                  @foreach($positions as $position)

                      <div class="col-md-4">

                          <div class="card mt-3">

                              <div class="card-header text-center">

                                  <h4 class="card-title">{{$position->vacancyName}}</h4>
                                  <p class="card-subtitle">{{trans_choice('{1} There is :count open position!|[2,*] There are :count open positions!', $position->vacancyCount)}}</p>


                              </div>

                              <div class="card-body text-center">

                                  <p class="card-text">
                                      {{$position->vacancyDescription}}
                                  </p>

                              </div>

                              <div class="card-footer text-center">
                                  @auth
                                      <button {{($isEligibleForApplication) ? '' : 'disabled'}} type="button" class="btn btn-success" onclick="window.location.href='{{route('renderApplicationForm', ['vacancySlug' => $position->vacancySlug])}}'">{{__('Apply')}}</button>
                                      @if(!$isEligibleForApplication)
                                          <span class="badge-warning badge"><i class="fa fa-info"></i> {{__('Ineligible (:days) day(s) remaining', ['days' => $eligibilityDaysRemaining])}}</span>
                                      @endif
                                  @endauth

                                  <button type="button" class="btn btn-info" onclick="$('#{{ $position->vacancySlug }}-details').modal('show')">{{__('Learn more')}}</button>

                                  @guest
                                          <button type="button" class="btn btn-success" onclick="window.location.href='{{route('renderApplicationForm', ['vacancySlug' => $position->vacancySlug])}}'">{{__('Apply')}}</button>
                                  @endguest

                              </div>

                          </div>

                      </div>

                  @endforeach

              @else

                  <div class="col-md-4 offset-md-4">

                      <div class="card">

                          <div class="card-header">

                              <div class="card-title"><h4>{{__('Applications Closed')}}</h4></div>

                          </div>

                          <div class="card-body">

                              <div class="alert alert-info">

                                  <p><b>{{__('Hello There!')}}</b></p>
                                  <p>
                                      {{__('We are currently not hiring any new staff members at the moment. If you\'d like to apply, check out our Discord\'s
      announcement channel for news when a new position opens.
      Our application cycle usually lasts two weeks, so if you\'re seeing this, it\'s because it finished, and new one will begin soon.')}}
                                  </p>

                              </div>

                          </div>

                      </div>

                  </div>

              @endif

          </div>

          <div class="row mt-5 mb-5">

              <div class="col text-center">

                  <h3>{{ __('A gestão da :appName responde a todas candidaturas dentro de 48 horas.', ['appName' => config('app.name')]) }}</h3>
                  <p>{!! __('Se você tiver algum dúvida sobre a sua conta de recrutamento, candidatura, ou qualquer outra questão, visite o nosso <a href=":supportURL" target="_blank">site de atendimento</a>, ou <a href="mailto::supportEmail">envie-nos um email</a>.', ['supportURL' => config('app.support_url'), 'supportEmail' => config('app.support_email')])  !!}</p>

              </div>

          </div>


	  </div>

	</main>
<!--Main Layout-->

@stop
