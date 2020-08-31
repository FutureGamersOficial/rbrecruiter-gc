@extends('adminlte::page')

@section('title', 'Raspberry Network | Open Positions')

@section('content_header')

    @if (Auth::user()->hasAnyRole('admin'))
        <h4>Administration / Settings</h4>
    @else
        <h4>Application Access Denied</h4>
    @endif

@stop

@section('js')

    @if (session()->has('success'))
        <script>
            toastr.success("{{session('success')}}")
        </script>
    @endif

    @if($errors->any())
        @foreach ($errors->all() as $error)
            <script>toastr.error('{{$error}}', 'Validation error!')</script>
        @endforeach
    @endif

@stop

@section('content')

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-header">
                    <h3>Notification Settings</h3>
                    <p>Change which notifications are sent here.</p>
                </div>

                <div class="card-body">
                    <form name="settings" id="settings" method="post" action="{{route('saveSettings')}}">
                        @foreach($options as $option)
                            <div class="form-group form-check">
                                <!-- Unchecked checkbox hack: This only works for serverside languages that process the last duplicate element, since the browser sends both the hidden and checkbox values. -->
                                <!-- This "hack" is necessary because browsers don't send, by default, unchecked checkboxes to the server, so we would have no way to know if X checkbox was unchecked. -->
                                <input type="hidden" name="{{$option->option_name}}" value="0">
                                <input type="checkbox" name="{{$option->option_name}}" value="1" id="{{$option->option_name}}" class="form-check-input" {{ ($option->option_value == 1) ? 'checked' : '' }}>
                                <label for="{{$option->option_name}}">{{$option->friendly_name}}</label>
                            </div>
                        @endforeach
                    </form>
                </div>

                <div class="card-footer">
                    <button type="button" class="btn btn-success" onclick="$('#settings').submit()"><i class="fa fa-save"></i> Save changes</button>
                    <button type="button" class="btn btn-warning" onclick="window.location.href='{{route('dashboard')}}'"><i class="fa fa-arrow-circle-o-left"></i> Back to Dashboard</button>
                </div>

            </div>

        </div>

    </div>

@stop
