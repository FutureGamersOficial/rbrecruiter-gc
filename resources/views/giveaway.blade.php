@extends('breadcrumbs.app')

@section('content')

	<!--Main Layout-->
	<main class="py-5">

	    <div class="container-fluid">


            <div class="row mt-4 mb-2">
                <div class="col text-center">

                    <h3>{{ __("Sorteio de Lançamento - 09/12/2021-13/12/2021") }}</h3>
                    
                    <p>Participe no sorteio abaixo para se habilitar aos variados prémios. Adira ao nosso Discord e venha-se divertir com a nossa comunidade!</p>
                </div>
            </div>


            <div class="row mb-2">
                <div class="col">
                    <a class="e-widget" href="https://gleam.io/2Ytjf/giveaway-among-us-gc" rel="nofollow">Giveaway Among Us - GC</a>
                    <script type="text/javascript" src="https://widget.gleamjs.io/e.js" async="true"></script>
                </div>
            </div>


            <div class="row mb-4">

                <div class="col text-center">

                    <a href="/" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Voltar</a>

                </div>

            </div>
    
	    </div>

	</main>
<!--Main Layout-->

@stop
