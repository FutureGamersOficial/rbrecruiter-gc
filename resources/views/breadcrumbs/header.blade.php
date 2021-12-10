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
    <meta name="description" content="{{ config('app.name') }} Staff Member Management Tool">
    <meta name="author" content="Miguel N.">
    <meta name="tags" content="minecraft, minecraft server staff, minecraft staff, minecraft servers">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">


    @switch (Route::currentRouteName())

        @case('home')

            <title>{{config('app.name')}} | {{ __('Home') }}</title>
            @break

        @case('giveaway')

            <title>{{config('app.name')}} | Sorteio oficial</title>

            <meta property="og:url" content="https://gleam.io/2Ytjf/giveaway-among-us-gc"/>
            <meta property="og:title" content="Ganhe Among Us na Steam">
            <meta property="twitter:card" content="summary"/>
            <meta property="fb:app_id" content="152351391599356"/>
            <meta property="og:description" content="Estamos a dar uma cópia gratuita do Among Us para a campanha de lançamento do Games Club, no valor de R$ 28. Among Us é um jogo eletrônico online, dos gêneros jogo em grupo e sobrevivência, desenvolvido e publicado pelo estúdio de jogos estadunidense InnerSloth. A Games Club está em desenvolvimento há algum tempo, e então, de modo a celebrar esta ocasião, estamos oferecendo este jogo para você poder jogar connosco. O sorteio é apenas uma pequena parte deste evento enorme, que oferece várias atrações. Junte-se ao Discord da GC!​ ​Condições do Sorteio NOTA: Prêmio apenas válido para usuários que atualmente não têm uma licensa digital associada ao jogo, e que tenham aderido ao servidor Discord da Games Club. A GC retém o direito de iniciar o processo de escolha automático no fim da competição no caso do vencedor não obedecer a estes termos.">

            @break;

    @endswitch
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

</header>
