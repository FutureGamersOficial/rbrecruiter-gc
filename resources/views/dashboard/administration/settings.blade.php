@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('messages.settings.settings'))

@section('content_header')

    @if (Auth::user()->hasAnyRole('admin'))
        <h4>{{__('messages.adm')}} / {{__('messages.settings.settings')}}</h4>
    @else
        <h4>{{__('messages.reusable.no_access')}}</h4>
    @endif

@stop

@section('js')

    @if (session()->has('success'))
        <script>
            toastr.success("{{session('success')}}")
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            toastr.error("{{session('error')}}")
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
                    <h3>{{__('messages.settings.settings_header')}}</h3>
                    <p>{{__('messages.settings.settings_p')}}</p>
                </div>

                <div class="card-body">
                    <form name="settings" id="settings" method="post" action="{{route('saveSettings')}}">
                        @csrf
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
                    <button type="button" class="btn btn-success" onclick="$('#settings').submit()"><i class="fa fa-save"></i> {{__('messages.vacancy.save')}}</button>
                    <button type="button" class="btn btn-warning" onclick="window.location.href='{{route('dashboard')}}'"><i class="fa fa-arrow-circle-o-left"></i> {{__('messages.settings.back_btn')}}</button>
                </div>

            </div>

        </div>

    </div>

@stop
