@if ($inDashboard)
  <div class="row mb-4">

    <div class="col-6 offset-5">


      <img src="/img/403.svg" width="150px"  alt="Access denied" />


    </div>

  </div>

  <div class="row">
      <!-- People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius -->
      <div class="col">

        <div class="alert alert-{{$type}}">
          <h4><i class="fas fa-user-lock"></i> {{__('messages.component_accessdenied')}}</h4>
          <p>
            {{__('messages.component_nopermission')}}
          </p>
          <p>
             {{__('messages.component_contact')}}
          </p>
        </div>

      </div>
  </div>

@else
  @extends('adminlte::page')

  @section('title', 'Raspberry Network | Access Denied')

  @section('content_header')
      <h4>Access Denied - HTTP 403</h4>
  @stop

  @section('content')
    <div class="row mb-4">

      <div class="col-6 offset-5">


        <img src="/img/403.svg" width="150px"  alt="Access denied" />


      </div>

    </div>

    <div class="row">
        <div class="col">

          <div class="alert alert-{{$type}}">
            <h4><i class="fas fa-user-lock"></i> Access Denied</h2>
              <p class="text-muted">
                @if (isset($slot))
                  {{ $slot }}
                @endif
              </p>
            <p>
              We're sorry, but you do not have permission to access this web page.
            </p>
            <p>
              Please contact your administrator if you believe this was in error.
            </p>
          </div>

        </div>
    </div>
  @stop
@endif
