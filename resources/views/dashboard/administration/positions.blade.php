@extends('adminlte::page')

@section('title',  config('app.name') . ' | ' . __('messages.open_positions'))

@section('content_header')

    @if (Auth::user()->hasAnyRole('admin', 'hiringManager'))
      <h4>{{__('messages.adm')}} / {{__('messages.open_positions')}}</h4>
    @else
      <h4>{{__('messages.reusable.no_access')}}</h4>
    @endif

@stop

@section('js')

    @if (session()->has('success'))

        <script>
            toastr.success("{{session('success')}}")
        </script>

    @elseif(session()->has('error'))
            <script>
                toastr.error("{{session('error')}}")
            </script>
    @endif

    @if($errors->any())

        @foreach ($errors->all() as $error)
            <script>toastr.error('{{$error}}', '{{__('messages.reusable.validation_err')}}')</script>
        @endforeach

    @endif

@stop

@section('content')
 @if (Auth::user()->hasAnyRole('admin', 'hiringManager'))
    <!-- todo: switch to modal component -->
    <div class="modal fade" tabindex="-1" id="newVacancyForm" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">{{__('messages.new_vacancy')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if(!$forms->isEmpty())

                        <form id="savePositionForm" action="{{route('savePosition')}}" method="POST">
                            @csrf
                            <label for="vacancyName">{{__('messages.vacancy.name')}}</label>
                            <input type="text" id="vacancyName" name="vacancyName" class="form-control">

                            <label for="vacancyDescription">{{__('messages.vacancy.description')}}</label>
                            <input type="text" id="vacancyDescription" name="vacancyDescription" class="form-control">

                            <label for="vacancyFullDescription">{{__('messages.vacancy.description')}}</label>
                            <textarea name="vacancyFullDescription" class="form-control" rel="txtTooltip" title="{{__('messages.vacancy.description_tooltip')}}" data-toggle="tooltip" data-placement="bottom"></textarea>
                            <span class="right text-muted"><i class="fab fa-markdown"></i> {{__('messages.vacancy.markdown')}}</span>
                            <div class="row mt-3">

                                <div class="col">
                                    <label for="pgroup">{{__('messages.vacancy.permission_group')}}</label>
                                    <input rel="txtTooltip" title="{{__('messages.vacancy.permission_group_tooltip')}}" data-toggle="tooltip" data-placement="bottom" type="text" id="pgroup" name="permissionGroup" class="form-control">
                                </div>

                                <div class="col">
                                    <label for="discordrole">{{__('messages.vacancy.discord_roleid')}} (*)</label>
                                    <input rel="txtTooltip" title="{{__('messages.vacancy.discord_roleid_tooltip')}}" data-toggle="tooltip" data-placement="bottom" type="text" id="discordrole" name="discordRole" class="form-control">
                                </div>

                            </div>

                            <div class="form-group mt-4">

                                <label for="associatedForm">{{__('messages.positions_p.application_form')}}</label>
                                <select class="custom-select" name="vacancyFormID" id="associatedForm">

                                    <option disabled>{{__('messages.positions_p.select_form')}}</option>
                                    @foreach($forms as $form)

                                        <option value="{{$form->id}}">{{$form->formName}}</option>

                                    @endforeach

                                </select>

                                <label for="vacancyCount">{{__('messages.vacancy.free_slots')}}</label>
                                <input rel="txtTooltip" title="{{__('messages.vacancy.free_slots_tooltip')}}" data-toggle="tooltip" data-placement="bottom" type="text" id="vacancyCount" name="vacancyCount" class="form-control">


                            </div>
                        </form>

                    @else

                        <div class="alert alert-danger">

                            <p>
                                {{__('messages.positions_p.no_form_error')}}
                            </p>
                        </div>

                    @endif

                </div>
                <div class="modal-footer">

                    @if(!$forms->isEmpty())
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('savePositionForm').submit()">{{__('messages.vacancy.add')}}</button>
                    @endif

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.modal_close')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4 offset-md-4 text-center">

            <div class="card">

                <div class="card-body">

                    <button type="button" class="btn btn-primary" onclick="$('#newVacancyForm').modal('show')">{{__('messages.positions_p.new_pos')}}</button>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">

            <div class="card bg-gray-dark">

                <div class="card-header bg-indigo">
                    <div class="card-title"><h4 class="text-bold">{{__('messages.open_positions')}}</h4></div>
                </div>

                <div class="card-body">

                    @if(!$vacancies->isEmpty())

                        <table class="table table-active table-borderless" style="white-space: nowrap">

                            <thead>

                            <tr>
                                <th>{{__('messages.contactlabel_name')}}</th>
                                <th>{{__('messages.reusable.description')}}</th>
                                <th>{{__('messages.vacancy.discord_roleid')}}</th>
                                <th>{{__('messages.vacancy.permission_group')}}</th>
                                <th>{{__('messages.vacancy.free_slots')}}</th>
                                <th>{{__('messages.reusable.status')}}</th>
                                <th>{{__('messages.reusable.created_at')}}</th>
                                <th>{{__('messages.reusable.actions')}}</th>
                            </tr>

                            </thead>

                            <tbody>

                            @foreach($vacancies as $vacancy)

                                <tr>
                                    <td>{{$vacancy->vacancyName}}</td>
                                    <td>{{substr($vacancy->vacancyDescription, 0, 20)}}...</td>
                                    <td><span class="badge badge-success">{{$vacancy->discordRoleID}}</span></td>
                                    <td><span class="badge badge-success">{{$vacancy->permissionGroupName}}</span></td>
                                    <td>{{$vacancy->vacancyCount}}</td>
                                    @if($vacancy->vacancyStatus == 'OPEN')
                                        <td><span class="badge badge-success">{{__('messages.open')}}</span></td>
                                    @else
                                        <td><span class="badge badge-danger">{{__('messages.closed')}}</span></td>
                                    @endif
                                    <td>{{$vacancy->created_at}}</td>
                                    <td>

                                        <button type="button" class="btn btn-sm btn-warning" onclick="window.location.href='{{ route('editPosition', ['vacancy' => $vacancy->id]) }}'"><i class="fas fa-edit"></i></button>

                                        @if ($vacancy->vacancyStatus == 'OPEN')

                                            <form action="{{route('updatePositionAvailability', ['status' => 'close', 'vacancy' => $vacancy->id])}}" method="POST" id="closePosition" style="display: inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i></button>
                                            </form>

                                        @else

                                            <form action="{{route('updatePositionAvailability', ['status' => 'open', 'vacancy' => $vacancy->id])}}" method="POST" id="openPosition" style="display: inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
                                            </form>

                                        @endif

                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="alert alert-warning">
                            <p>{{__('messages.positions_p.empty_pos_warning')}}</p>
                        </div>

                    @endif
                </div>

                <div class="card-footer">

                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route('showForms')}}'">{{__('messages.positions_p.manage_forms')}}</button>

                </div>

            </div>

        </div>

    </div>
 @else
   <x-no-permission type="danger"></x-no-permission>
 @endif
@stop

@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
