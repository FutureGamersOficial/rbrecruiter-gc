<!doctype HTML>

<html lang="en">

<head>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T47K5CG');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <meta name="author" content="GC">
    <meta name="robots" content="index, follow">
    <meta name="tags" content="gamesclub, gamescluboficial, games club oficial, games club discord, minecraft, gaming, discord">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">


    <title>{{config('app.name')}} | {{ __('Home') }}</title>
    <meta name="title" content="Games Club Oficial | Página Inicial">
    <meta name="description" content="Games Club Oficial - Onde sua diversão acontece!">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">

    <link href="https:////cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.2.1/css/lightgallery-bundle.min.css" integrity="sha256-Uxm/PH2he1eJjDjL9GpZSqxO3+ibyFsbhGupVTc9qLg=" crossorigin="anonymous">

    <link href="/app.css" rel="stylesheet">

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script>

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://betteruptime.com/widgets/announcement.js" data-id="131937" async="async" type="text/javascript"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>

<!--Main Navigation-->
<header>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
            <img class="rounded" src="/logo-gc.png" alt="Logo Gamesclub" height="50px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto float-right">
                @guest
                    <li class="nav-item">
                        <button class="btn btn-info" type="button" onclick="window.location.href='{{route('login')}}'"><i class="fas fa-sign-in-alt"></i> {{__('messages.login')}}</button>
                    </li>

                    <li class="nav-item">
                        <button class="btn btn-info" type="button" onclick="window.location.href='{{route('register')}}'"><i class="fas fa-plus"></i> {{__('messages.register')}}</button>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <button type="button" class="btn btn-info" onclick="window.location.href='{{route('dashboard')}}'">{{__('messages.dashboard')}}</button>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button type="submit" class="btn btn-danger"><i class="fa fa-power-off"></i>{{__('messages.logout')}}</button>
                        </form>
                    </li>
                @endauth

            </ul>
        </div>
    </nav>

    <!-- hero -->
    @if (!isset($code))

        <div class="view intro-2">
            <div class="full-bg-img">
                <div class="mask rgba-black-light flex-center">
                    <div class="container text-center white-text">
                        <div class="white-text text-center wow fadeInUp">
                            <h2>{{config('app.name')}}</h2>
                            <h5>Seja bem-vindo ao site oficial da Games Club</h5>
                            <br>
                            <p>A Games Club é uma comunidade brasileira que busca trazer um experiência própria e exclusiva para cada participante, temos o intuito de se tornar uma comunidade forte, grande, bem respeitada e, além disso tudo se tornar uma segunda família para muitas pessoas.</p>
                            <br>
                            <p>Aqui você se preocupará apenas nas gameplays e em fazer novas amizades para suas jogatinas, até mesmo para trocar ideias e jogar conversa fora.</p>
                            <p>Atendemos todos os públicos, somos uma comunidade de jogos mais não se limitamos somente a jogos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- this is not ideal, and the whole frontend desperately needs a redesign, it's ugly and hard to maintain -->
            <div class="view intro-2">
                <div class="full-bg-img">
                    <div class="mask rgba-black-light flex-center">
                        <div class="container text-center white-text">
                            <div class="white-text text-center wow fadeInUp">
                                @switch($code)

                                    @case(404)
                                        <img class="d-inline mb-4" src="{{ asset('img/404.svg') }}" width="350px" alt="404 illustration">

                                        <h1>{{ __('404 - Page Not Found') }}</h1>
                                        <p>{{ __('Uh oh! We searched far and wide, but it looks like the page you were looking for could not be found.') }}</p>
                                        @break;

                                    @case(500)
                                        <img class="d-inline mb-4" src="{{ asset('img/500.svg') }}" width="350px" alt="500 illustration">

                                        <h1>{{ __('500 - Internal Server Error') }}</h1>
                                        <p>{{ __('Whelp! It looks like our servers went up in flames. Don\'t worry, it\'s not your fault. Our developers have been notified & are already extinguishing the flames and repairing the damage. ') }}</p>
                                        @break;

                                    @case(401)
                                        <img class="d-inline mb-4" src="{{ asset('img/401.svg') }}" width="350px" alt="401 illustration">

                                        <h1>{{ __('401 - Unauthorized') }}</h1>
                                        <p>{{ __('You need to be authenticated to access this page. Believe this is a mistake? Contact us and let us know! ') }}</p>
                                        @break;

                                    @case(403)
                                        <img class="d-inline mb-4" src="{{ asset('img/403.svg') }}" width="350px" alt="403 illustration">

                                        <h1>{{ __('403 - Forbidden') }}</h1>
                                        <p>{{ __('Hey there :accountName! It looks like you don\'t have permission to access this resource. Believe this is a mistake? Contact us and we\'ll sort it out!', ['accountName' => Auth::user()->name]) }}</p>
                                        @break;

                                    @case(503)
                                        <img class="d-inline mb-4" src="{{ asset('img/503.svg') }}" width="350px" alt="503 illustration">

                                        <h1>{{ __('503 - Service Unavailable') }}</h1>
                                        <p>{{ __('Our services are currently undergoing routine maintenance. We are sorry for any inconveniences caused! We\'ll be back ASAP.') }}</p>
                                        @break;

                                @endswitch

                                    <a class="mt-3 ml-3 btn btn-primary btn-lg" href="{{route('home')}}" role="button"><i class="fas fa-home"></i> {{ __('Back to safety') }}</a>
                                    <a target="_blank" class="mt-3 ml-3 btn btn-primary btn-lg" href="https://status.gamescluboficial.com.br" role="button"><i class="fas fa-cogs"></i> {{ __('System status') }}</a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

    @endif

</header>
