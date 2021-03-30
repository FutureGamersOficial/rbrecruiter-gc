@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('API Key Management'))

@section('content_header')

    <h4>Profile / Settings / API Keys</h4>

@stop

@section('js')
    <x-global-errors></x-global-errors>
@stop

@section('content')

    <x-modal id="createKeyModal" modal-label="createKeyModalLabel" modal-title="New API Key" include-close-button="true">

        <form id="createKey" method="post" action="{{ route('keys.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Give your new API key a name to easily identify it.</label>
                <input type="text" name="keyName" class="form-control" id="name" required>
            </div>

        </form>

        <x-slot name="modalFooter">
            <button onclick="$('#createKey').submit()" type="button" class="btn btn-success"><i class="fas fa-key"></i> Register new key</button>
        </x-slot>

    </x-modal>

    <div class="row">
        <div class="col">
            <div class="alert alert-warning">
                <p><i class="fas fa-exclamation-triangle"></i> <b>Friendly reminder: </b> API keys can access your whole account and the resources it has access to. Please treat them like a password. If they are leaked, please revoke them.</p>
            </div>
        </div>
    </div>

    @if (session()->has('finalKey'))
        <div class="row">
            <div class="col">
                <div class="alert alert-success">
                    <p><i class="fas fa-key"></i> This is your API key: {{ session('finalKey') }}</p>
                    <p>Please copy it <b>now</b> as it'll only appear once.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <x-card id="keyListing" card-title="Manage API Keys" footer-style="text-center">

                <x-slot name="cardHeader"></x-slot>

                @if(!$keys->isEmpty())
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Key name</th>
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
                                        @endif
                                        <form class="d-inline-block" action="{{ route('keys.destroy', ['key' => $key->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <div class="alert alert-success">
                        <p><i class="fa fa-info-circle"></i> You don't have any API keys yet.</p>
                    </div>
                @endif

                <x-slot name="cardFooter">
                    <button onclick="$('#createKeyModal').modal('show')" type="button" class="btn btn-secondary"><i class="fas fa-plus"></i> New API Key</button>
                </x-slot>

            </x-card>
        </div>
    </div>

@stop


@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
