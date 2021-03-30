@extends('adminlte::page')

@section('title', config('app.name') . ' | Key Administration')

@section('content_header')

    <h4>{{__('messages.adm')}} / API Key Administration</h4>

@stop

@section('js')

    <x-global-errors></x-global-errors>

@stop

@section('content')

    <div class="row">
        <div class="col">
            <div class="alert alert-primary">
                <p><i class="fas fa-info-circle"></i> You can use the key discriminator to identify it's API calls in the logs.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">

            <x-card id="adminKeys" card-title="API Key Monitoring & Administration" footer-style="text-center">

                <x-slot name="cardHeader">
                    <p class="card-text">Here, you can view and manage all API keys created by users in the app. You can't, however, use this page to access someone else's account.</p>
                </x-slot>


                @if(!$keys->isEmpty())
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Discriminator</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th>Last Used</th>
                            <th>Last Modified</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($keys as $key)
                            <tr>
                                <td>{{ $key->name }}</td>
                                <td id="discr{{$key->id}}">{{ $key->discriminator }}</td>
                                <td><a href="{{ route('showSingleProfile', ['user' => $key->user->id]) }}">{{ $key->user->name }}</a></td>
                                <td><span class="badge badge-{{ ($key->status == 'disabled') ? 'danger' : 'primary' }}">{{ ($key->status == 'disabled') ? 'Revoked' : 'Active' }}</span></td>
                                <td><span class="badge badge-{{ ($key->last_used == null) ? 'danger' : 'primary' }}">{{ ($key->last_used == null) ? 'No recent activity' : $key->last_used }}</span></td>
                                <td><span class="badge badge-primary">{{ $key->updated_at }}</span></td>
                                <td>
                                    @if ($key->status == 'active')
                                        <form class="d-inline-block" action="{{ route('revokeKey', ['key' => $key->id]) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm ml-2"><i class="fas fa-lock"></i> Revoke</button>
                                        </form>
                                    @else
                                        <button disabled type="button" class="btn btn-danger btn-sm ml-2"><i class="fas fa-lock"></i> Revoke</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @else
                    <div class="alert alert-success">
                        <p><i class="fa fa-info-circle"></i> No API keys have been registered yet.</p>
                    </div>
                @endif


                <x-slot name="cardFooter">
                    <button onclick="window.location.href='{{ route('keys.index') }}'" type="button" class="btn btn-success ml-2"><i class="fas fa-key"></i> Your Keys</button>
                    <button type="button" onclick="window.location.href='/admin/maintenance/system-logs'" class="btn btn-secondary"><i class="fas fa-clipboard"></i> Search Logs</button>
                </x-slot>

            </x-card>

        </div>
    </div>

@stop


@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
