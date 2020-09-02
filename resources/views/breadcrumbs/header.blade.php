<!doctype HTML>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="description" content="The Minecraft Staff Member Management Tool">
    <meta name="author" content="Miguel Nogueira">
    <meta name="tags" content="minecraft, minecraft server staff, minecraft staff, minecraft servers">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{config('app.name')}} | {{__('messages.home')}}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">

    <link href="https:////cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

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

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>

<!--Main Navigation-->
<header>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#"><strong>{{config('app.name')}}</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link " href="{{config('app.sitehomepage')}}">{{__('messages.homepagetxt')}}</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle">Language selection</a>
                    <ul class="dropdown-menu">
                        @foreach(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li class="dropdown-item">
                                <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
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

    <div class="view intro-2">
        <div class="full-bg-img">
            <div class="mask rgba-black-light flex-center">
                <div class="container text-center white-text">
                    <div class="white-text text-center wow fadeInUp">
                        <h2>{{config('app.name')}}</h2>
                        <h5> {{__('messages.homepage_welcome')}}</h5>
                        <br>
                        <p>{{__('messages.homepage_explainer_line1')}}</p>
                        <p>{{__('messages.homepage_explainer_line2')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
