@extends('breadcrumbs.app')

@section('content')

    <div class="row mt-4 mb-2">

        <div class="col">
            <div class="alert alert-info">
                <p class="text-bold"><i class="fas fa-bullhorn"></i> {{ __("Anúncio Oficial - Equipe de Direção GC") }}</p>

                <p>A Games Club está finalmente pronta para começar a todo gás! A nossa inauguração ofical será celebrada na nossa comunidade Discord a 11/12/2021.</p>
                <p>Como um incentivo a novos usuários, e para recompensar quem esteve connosco desde o inicio, a Games Club está a organizar um sorteio de <b>Among Us</b> e 2 vales-presente no valor de R$10.</p>

                <p>Participe do sorteio e adira à nossa comunidade Discord!</p>

                <p>Feliz natal! <i class="fas fa-gifts"></i></p>

                <p class="text-bold">- A equipe de direção Games Club</p>
            </div>
        </div>

    </div>

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

          @if ($demoActive)
              <div class="row">
                  <div class="col">
                      <div class="alert alert-warning">
                          <p class="font-weight-bold"><i class="fas fa-exclamation-circle"></i> Attention</p>
                          <p>Demo mode is active on this instance. The database is refreshed daily and some features are disabled for security reasons.</p>

                          <p>If you're seeing this message in error, please contact your system administrator.</p>
                      </div>
                  </div>
              </div>
          @endif

        <div class="row">

            <div class="col-8">

                <div class="jumbotron">
                    <img class="jumbotron-header" src="/header.png">

                    <h1 class="display-4">Junte-se ao nosso Discord!</h1>
                    <p class="lead">O Discord é o coração da nossa comunidade — onde toda a diversão acontece.</p>
                    <hr class="my-4">
                    <p>Venha conhecer a nossa comunidade de perto aderindo ao nosso servidor Discord. Conheça novos amigos, jogos, vários minigames divertidos e fale com a nossa equipe amigável! Todo mundo é bem-vindo.</p>
                    <p>Registre-se também no nosso portal online, que lhe permite gerir suas candidaturas à nossa equipe, ligar a sua conta Discord (e receber vantagens no servidor!), ver o diretório de usuários, fazer doação e muito mais!</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="https://discord.gg/tbxKEEeBpf" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-discord" viewBox="0 0 16 16">
                            <path d="M6.552 6.712c-.456 0-.816.4-.816.888s.368.888.816.888c.456 0 .816-.4.816-.888.008-.488-.36-.888-.816-.888zm2.92 0c-.456 0-.816.4-.816.888s.368.888.816.888c.456 0 .816-.4.816-.888s-.36-.888-.816-.888z"/>
                            <path d="M13.36 0H2.64C1.736 0 1 .736 1 1.648v10.816c0 .912.736 1.648 1.64 1.648h9.072l-.424-1.48 1.024.952.968.896L15 16V1.648C15 .736 14.264 0 13.36 0zm-3.088 10.448s-.288-.344-.528-.648c1.048-.296 1.448-.952 1.448-.952-.328.216-.64.368-.92.472-.4.168-.784.28-1.16.344a5.604 5.604 0 0 1-2.072-.008 6.716 6.716 0 0 1-1.176-.344 4.688 4.688 0 0 1-.584-.272c-.024-.016-.048-.024-.072-.04-.016-.008-.024-.016-.032-.024-.144-.08-.224-.136-.224-.136s.384.64 1.4.944c-.24.304-.536.664-.536.664-1.768-.056-2.44-1.216-2.44-1.216 0-2.576 1.152-4.664 1.152-4.664 1.152-.864 2.248-.84 2.248-.84l.08.096c-1.44.416-2.104 1.048-2.104 1.048s.176-.096.472-.232c.856-.376 1.536-.48 1.816-.504.048-.008.088-.016.136-.016a6.521 6.521 0 0 1 4.024.752s-.632-.6-1.992-1.016l.112-.128s1.096-.024 2.248.84c0 0 1.152 2.088 1.152 4.664 0 0-.68 1.16-2.448 1.216z"/>
                        </svg> Aderir ao Discord</a>
                        <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button"><i class="fas fa-plus"></i> Aderir ao portal</a>
                    </p>

                </div>

            </div>

            <div class="col text-center">
                <iframe src="https://discord.com/widget?id=866521211550433301&theme=dark" width="350px" height="95%" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
            </div>

        </div>


          <div class="row mt-5">

              <div class="col text-center">
                  <img src="/community.svg" height="250px" alt="community decorative svg">

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

                                  <button type="button" class="btn btn-info" onclick="$('#{{ $position->vacancySlug }}-details').modal('show')">{{__('messages.txt_learn_more')}}</button>

                                  @guest
                                          <button type="button" class="btn btn-success" onclick="window.location.href='{{route('renderApplicationForm', ['vacancySlug' => $position->vacancySlug])}}'">{{__('messages.txt_apply')}}</button>
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

                  <h3>Conheça a Games Club</h3>

              </div>

          </div>

          <div class="row mt-5 mb-5">

              <div id="carouselControls" class="carousel slide w-100" data-ride="carousel">
                  <div class="carousel-inner">
                      <div class="carousel-item active">
                          <img class="d-block w-100" src="/slides/ets2.01.jpg"
                               alt="Pic from ETS2">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/ets2.02.png"
                               alt="Pic from ETS2">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/ets2.03.png"
                               alt="Pic from ETS2">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/fs19.01.png"
                               alt="Pic from Farming Sim">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/fs19.02.png"
                               alt="Pic from Farming Sim">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/fs19.03.png"
                               alt="Pic from Farming Sim">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/gtav.01.png"
                               alt="Pic from GTAV">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/gtav.02.png"
                               alt="Pic from GTAV">
                      </div>
                      <div class="carousel-item">
                          <img class="d-block w-100" src="/slides/gtav.03.png"
                               alt="Pic from GTAV">
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

          <div class="row">
            <div class="col">
                <p class="text-muted text-center">Créditos: Ryan Gabriel#8868 (Farming Simulator), BruceThompsonN#4217 (GTA V), CaioSFela2TI#5555 e Oliveira#3800 (ETS2)</p>
            </div>
          </div>


          <div class="row mt-5 mb-5">

              <div class="col text-center">

                  <h3>Convencido?</h3>

              </div>

          </div>

          <div class="row">

              <div class="col text-center">
											<p>
												 Esperamos você! Junte-se hoje e desfrute de uma nova experiência.
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
