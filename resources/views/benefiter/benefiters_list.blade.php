@extends('layouts.mainPanel')

<?php
    $p = "benefiters_list.";
?>

@section('panel-headLinks')
    <link href="{{asset('css/main-panel/benefiters-list.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('panel-title')
    @lang($p."benefiters_list")
@endsection

@section('main-window-content')

    <div class="no-margin pos-relative" id="results-to-activate">
        <div class="display padding-20">
            <table id="usersTable-to-activate" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>@lang("basic_info_form.folder_number")</th>
                    <th>@lang("basic_info_form.name")</th>
                    <th>@lang("basic_info_form.lastname")</th>
                    <th>@lang($p."contact")</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>@lang("basic_info_form.folder_number")</th>
                    <th>@lang("basic_info_form.name")</th>
                    <th>@lang("basic_info_form.lastname")</th>
                    <th>@lang($p."contact")</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($benefiters as $benefiter)
                        <tr>
                            <td>{{ $benefiter['folder_number'] }}</td>
                            <td>{{ $benefiter['name'] }}</td>
                            <td>{{ $benefiter['lastname'] }}</td>
                            <td>{{ $benefiter['telephone'] }}</td>
                            <td>
                                {!! Form::open(array('url' => 'benefiter/'. $benefiter['id'] .'/basic-info', 'method' => 'get')) !!}
                                    {!! Form::hidden('benefiter_id', $benefiter['id']) !!}
                                    {!! Form::submit(\Lang::get('benefiters_list.edit'), array('class' => 'edit-button lighter-green-background')) !!}
                                    @if(\Auth::user()->user_role_id == 1)
                                    <a href="javascript:void(0)" data-url="{{ url('/benefiter/'.$benefiter['id'].'/delete') }}" class="delete-benefiter display-inline margin-left-10px gray" title="@lang($p."delete_benefiter")"><span class="glyphicon glyphicon-trash"></span></a>
                                    @endif
                                {!! Form::close() !!}
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--delete session confirmation modal-->
    <div class="modal fade" id="delete-benefiter-modal" aria-hidden="true" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="delete-benefiter-form" action="" method="get">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@lang($p."delete_benefiter_modal_title")</h4>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xs-3 col-xs-offset-9">
                            <button type="submit" class="simple-button">@lang($p."done")</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->

@stop

@section('panel-scripts')
    <script src="{{ asset('/bootstrap-3.3.6/js/modal.js') }}"></script>
    <script src="{{asset('js/main-panel/users-list.js')}}"></script>
    <script src="{{asset('js/main-panel/selectBenefitersListInMainPanel.js')}}"></script>
    <script src="{{ asset('js/main-panel/benefiters_list.js') }}"></script>
@stop
