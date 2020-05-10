@extends('adminlte::page')

@section('title', 'Raspberry Network Team Management')

@section('content_header')
    <h1>Team Management Panel | Backoffice</h1>
@stop

@section('content')

    <div class="row">

        <div class="col">

            @if (!is_null($mcstatus))

                @if($mcstatus[4]['sessionserver.mojang.com'] == 'red')

                    <div class="alert alert-danger">
                        <h4>Mojang's session servers are (apparently) down</h4>

                        <p>If you see missing profile pictures in our dashboard or in the staff list (homepage), or are unable to login to Raspberry Network or Minecraft itself, be advised that Mojang's session server is currently experiencing technical difficulties.</p>
                        <p>We hope this issue is resolved soon! For more information please visit the Mojang <a href="https://help.minecraft.net/hc/en-us">Support Center</a>.</p>

                        <p class="text-bold">Raspberry Network and Spacejewel Hosting are not affiliated with Mojang AB or Microsoft Corporation. Minecraft(™) is a trademark of Mojang AB.</p>
                    </div>

                @else

                    <div class="alert alert-success">

                        <p>All OK! Feel free to explore the team management dashboard, manage your applications, or join our server.</p>

                    </div>

                @endif

            @endif

        </div>
    </div>

    <div class="row">

        <div class="col">
            <div class="alert alert-info">

                <p>Your current application eligibility status: <span class="badge badge-warning">{{($isEligibleForApplication) ? 'Eligibile' : 'Ineligible' }}</span></p>

            </div>
        </div>

    </div>

@stop
