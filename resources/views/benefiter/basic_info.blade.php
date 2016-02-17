@extends('layouts.mainPanel')

@section('panel-title')
    Νέος Ωφελούμενος
@stop

@section('panel-headLinks')
    <link href="{{ asset('/plugins/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/new_record_panel.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/records/validation_errors.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/record_form.css')}}" rel="stylesheet" type="text/css">
@stop

@section('main-window-content')

    @include('partials.select-panel')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('partials.forms.basic_info_form')
@stop

@section('panel-scripts')
    <script src="{{ asset('/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/records/selectNewRecordInMainPanel.js') }}"></script>
    <script src="{{asset('js/records/basic_info.js')}}"></script>
@stop
