@extends('breadcrumbs.app')

@section('content')

	<!--Main Layout-->
	<main class="py-5">

	  <div class="container-fluid">

          <div class="row">

              <div class="col text-center">

                  <h3>Open Positions</h3>

              </div>

          </div>

          <div class="row mt-5 mb-5">

              @if (!$positions->isEmpty())

                  @foreach($positions as $position)

                      <div class="col-md-4">

                          <div class="card">

                              <div class="card-header text-center">

                                  <h4 class="card-title">{{$position->vacancyName}}</h4>
                                  @if ($position->vacancyCount == 1)
                                      <p class="card-subtitle">There is <span class="badge badge-success">{{$position->vacancyCount}}</span> open position!</p>
                                  @else
                                      <p class="card-subtitle">There are <span class="badge badge-success">{{$position->vacancyCount}}</span> open positions!</p>
                                  @endif


                              </div>

                              <div class="card-body text-center">

                                  <p class="card-text">
                                      {{$position->vacancyDescription}}
                                  </p>

                              </div>

                              <div class="card-footer text-center">

                                  <button type="button" class="btn btn-success" onclick="window.location.href='{{route('renderApplicationForm', ['vacancySlug' => $position->vacancySlug])}}'">Apply</button>

                              </div>

                          </div>

                      </div>

                  @endforeach

              @else

                  <div class="col-md-4 offset-md-4">

                      <div class="card">

                          <div class="card-header">

                              <div class="card-title"><h4>Applications Closed</h4></div>

                          </div>

                          <div class="card-body">

                              <div class="alert alert-info">

                                  <p><b>Hello there!</b></p>
                                  <p>
                                      We are currently not hiring any new staff members at the moment. If you'd like to apply, check out our Discord's
                                      announcement channel for news when a new position opens.
                                      Our application cycle usually lasts two weeks, so if you're seeing this, it's because it finished, and new one will begin soon.
                                  </p>

                              </div>

                          </div>

                      </div>

                  </div>

              @endif

          </div>

          <div class="row mt-5 mb-5">

              <div class="col text-center">

                  <h3>Where you'll work</h3>

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
                      <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                  </a>
              </div>

          </div>


          <div class="row mt-5 mb-5">

              <div class="col text-center">

                  <h3>Join The Team</h3>

              </div>

          </div>

          <div class="row">

              <div class="col text-center">

                  <div class="card">

                      <!-- Card content -->
                      <div class="card-body text-center">

                          <!-- Title -->
                          <img src="https://crafatar.com/avatars/6102256a-bd28-4dd7-b68e-4c96ef313734" class="img-fluid mb-3" alt="miguel456's avatar">

                          <h4 class="card-title text-center"><a>miguel456</a></h4>
                          <!-- Text -->
                          <p class="card-text">Network Owner / Web Developer</p>

                      </div>

                      <div class="card-footer">

                          <button type="button" class="btn btn-info">More Info</button>

                      </div>

                  </div>

              </div>

              <div class="col text-center">

                    <div class="card">


                        <div class="card-body">
                            <h4 class="card-title">Moderator</h4>
                            <p class="card-text">Open Position!</p>

                        </div>

                        <div class="card-footer">

                            <button type="button" class="btn btn-success">Apply</button>

                        </div>

                    </div>

              </div>

              <div class="col text-center">

                  <div class="card">

                      <div class="card-body">
                          <h4 class="card-title">Helper</h4>

                          <p class="card-text">Open Position!</p>

                      </div>

                      <div class="card-footer">

                          <button type="button" class="btn btn-success">Apply</button>

                      </div>

                  </div>

              </div>

          </div>

          <div class="row text-center mt-5 mb-4">

              <div class="col">

                  <h3>Any questions? Leave a message!</h3>
                  <p class="text-muted">*This is not an application form. Any applications sent here will be ignored.</p>


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
                                  <label for="firstName">Name</label>

                              </div>
                          </div>

                          <div class="col-md-6">

                              <div class="md-form">

                                  <input type="email" name="email" class="form-control" id="email">
                                  <label for="email">E-mail</label>

                              </div>

                          </div>

                      </div>


                      <div class="col-md-12">

                          <div class="md-form">

                              <input type="text" name="subject" id="subject" class="form-control">
                              <label for="subject">Subject (ex. Suggestion)</label>

                          </div>

                      </div>

                      <div class="col-md-12">

                          <div class="md-form">

                              <textarea rows="3" name="message" id="message" class="md-textarea form-control"></textarea>

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

                  <button type="button" class="btn btn-info" onclick="document.getElementById('contactForm').submit()">Send</button>

              </div>

          </div>

	  </div>

	</main>
<!--Main Layout-->

@stop
