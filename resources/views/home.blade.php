@extends('breadcrumbs.app')

@section('content')

	@if(!$positions->isEmpty())

		<!-- todo: details component -->

		@foreach($positions as $position)
				<x-modal id="{{ $position->vacancySlug . '-details' }}" modal-label="{{ $position->vacancySlug . '-details-label' }}" modal-title="{{__('messages.details_m_title')}}" include-close-button="true">

					@if (is_null($position->vacancyFullDescription))

						<div class="alert alert-warning">

							<h3><i class="fas fa-question-circle"></i> {{__('messages.opening_nodetails')}}</h3>
							<p>
								{{__('messages.opening_nodetails_exp')}}
							</p>

						</div>
					@else

						{!! $position->vacancyFullDescription !!}
						<p class="text-sm text-muted">
							{{__('messages.last_updated')}} @ {{ $position->updated_at }}
						</p>
					@endif

					<x-slot name="modalFooter"></x-slot>

				</x-modal>

		@endforeach


	@endif

	<!--Main Layout-->
	<main class="py-5">

	  <div class="container-fluid">

          <div class="row">

              <div class="col text-center">

                  <h3>{{__('messages.open_positions')}}</h3>

              </div>

          </div>

          <div class="row mt-5 mb-5">

              @if (!$positions->isEmpty())

                  @foreach($positions as $position)

                      <div class="col-md-4">

                          <div class="card mt-3">

                              <div class="card-header text-center">

                                  <h4 class="card-title">{{$position->vacancyName}}</h4>
                                  <p class="card-subtitle">{{trans_choice('messages.open_position_count', $position->vacancyCount)}}</p>


                              </div>

                              <div class="card-body text-center">

                                  <p class="card-text">
                                      {{$position->vacancyDescription}}
                                  </p>

                              </div>

                              <div class="card-footer text-center">
                                  @auth
                                      <button {{($isEligibleForApplication) ? '' : 'disabled'}} type="button" class="btn btn-success" onclick="window.location.href='{{route('renderApplicationForm', ['vacancySlug' => $position->vacancySlug])}}'">{{__('messages.txt_apply')}}</button>
                                      @if(!$isEligibleForApplication)
                                          <span class="badge-warning badge"><i class="fa fa-info"></i> {{__('messages.ineligible_days_remaining', ['days' => $eligibilityDaysRemaining])}}</span>
                                      @endif
                                  @endauth

                                  @guest
                                          <button type="button" class="btn btn-success" onclick="window.location.href='{{route('renderApplicationForm', ['vacancySlug' => $position->vacancySlug])}}'">{{__('messages.txt_apply')}}</button>
                                          <button type="button" class="btn btn-info" onclick="$('#{{ $position->vacancySlug }}-details').modal('show')">{{__('messages.txt_learn_more')}}</button>
                                  @endguest

                              </div>

                          </div>

                      </div>

                  @endforeach

              @else

                  <div class="col-md-4 offset-md-4">

                      <div class="card">

                          <div class="card-header">

                              <div class="card-title"><h4>{{__('messages.application_closed')}}</h4></div>

                          </div>

                          <div class="card-body">

                              <div class="alert alert-info">

                                  <p><b>{{__('messages.application_closed_intro')}}</b></p>
                                  <p>
                                      {{__('messages.application_closed_intro_line2')}}
                                  </p>

                              </div>

                          </div>

                      </div>

                  </div>

              @endif

          </div>

          <div class="row mt-5 mb-5">

              <div class="col text-center">

                  <h3>{{__('messages.where_work')}}</h3>

              </div>

          </div>

          <div class="row mt-5 mb-5">

              <div id="carouselControls" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                      <div class="carousel-item active">
                          <img class="d-block w-100" src="/slides/01.png"
                               alt="Hub Side View">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/02.png"
                               alt="Hub Top View">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/03.png"
                               alt="Network Servers">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/04.png"
                               alt="Prison Mines">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/05.png"
                               alt="Modified Survival">
                      </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">{{__('pagination.previous')}}</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">{{__('pagination.next')}}</span>
                  </a>
              </div>

          </div>


          <div class="row mt-5 mb-5">

              <div class="col text-center">

                  <h3>{{__('messages.join_team')}}</h3>

              </div>

          </div>

          <div class="row">

              <div class="col text-center">
											<p>
												 {{__('messages.join_team_cta')}}
											</p>
							</div>


          </div>

          <div class="row text-center mt-5 mb-4">

              <div class="col">

                  <h3>{{__('messages.contact_cta')}}</h3>
                  <p class="text-muted">{{__('messages.contact_disclaimer')}}</p>


              </div>

          </div>

          <div class="row text-center">

              <div class="col">



                  <form method="POST" action="{{route('sendSubmission')}}" id="contactForm">
                      @csrf

                      <!-- Tamper warning: Your captcha will fail if you modify this value programmatically/manually. -->
                      <input type="hidden" name="captcha" id="captcha">

                      <div class="row">

                          <div class="col-md-6">
                              <div class="md-form">

                                  <input type="text" name="name" class="form-control" id="firstName">
                                  <label for="firstName">{{__('messages.contactlabel_name')}}</label>

                              </div>
                          </div>

                          <div class="col-md-6">

                              <div class="md-form">

                                  <input type="email" name="email" class="form-control" id="email">
                                  <label for="email">{{__('messages.contactlabel_email')}}</label>

                              </div>

                          </div>

                      </div>


                      <div class="col-md-12">

                          <div class="md-form">

                              <input type="text" name="subject" id="subject" class="form-control">
                              <label for="subject">{{__('messages.contactlabel_subject')}}</label>

                          </div>

                      </div>

                      <div class="col-md-12">

                          <div class="md-form">

                              <textarea rows="3" name="msg" id="message" class="md-textarea form-control"></textarea>

                          </div>

                      </div>

                  </form>

              </div>

          </div>

          <div class="row text-center">

              <div class="col">

                  <script>
                      function gcallback(response)
                      {
                          document.getElementById('captcha').value = response
                      }
                  </script>

                    <!-- align: deprecated cheap hack, but quick -->
                  <div align="center" class="g-recaptcha pb-3" data-callback="gcallback" data-sitekey="{{config('recaptcha.keys.sitekey')}}"></div>

                  <button type="button" class="btn btn-info" onclick="document.getElementById('contactForm').submit()">{{__('messages.contactlabel_send')}}</button>

              </div>

          </div>

	  </div>

	</main>
<!--Main Layout-->

@stop
