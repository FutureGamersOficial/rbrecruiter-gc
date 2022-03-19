@if ($inDashboard)
  <div class="row mb-4">

    <div class="col-6 offset-5">


      <img src="/img/403.svg" width="150px"  alt="{{ __('Image Describing Access Denied') }}" />


    </div>

  </div>

  <div class="row">
      <!-- People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius -->
      <div class="col">

        <div class="alert alert-{{$type}}">
          <h4><i class="fas fa-user-lock"></i> {{__('Access Denied')}}</h4>
          <p>
            {{__("We're sorry, but you do not have sufficient permission to access this web page.")}}
          </p>
          <p>
             {{__('Please contact your administrator if you believe this was in error.')}}
          </p>
        </div>

      </div>
  </div>

@else
  @extends('adminlte::page')

  @section('title', config('app.name') . ' | ' . __('Access Denied'))

  @section('content_header')
      <h4>{{ __('Access Denied - HTTP 403') }}</h4>
  @stop

  @section('content')
    <div class="row mb-4">

      <div class="col-6 offset-5">


          <img src="/img/403.svg" width="150px"  alt="{{ __('Image Describing Access Denied') }}" />


      </div>

    </div>

    <div class="row">
        <div class="col">

          <div class="alert alert-{{$type}}">
            <h4><i class="fas fa-user-lock"></i> {{ __('Access Denied') }}</h4>
              <p class="text-muted">
                @if (isset($slot))
                  {{ $slot }}
                @endif
              </p>
            <p>
              {{ __("We're sorry, but you do not have permission to access this web page.") }}
            </p>
            <p>
              {{ __('Please contact your administrator if you believe this was in error.') }}
            </p>
          </div>

        </div>
    </div>
  @stop
@endif
