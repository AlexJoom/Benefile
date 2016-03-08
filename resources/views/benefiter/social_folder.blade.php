@extends('layouts.mainPanel')

@section('panel-title')
    @lang('social_folder_form.social_folder')
@stop

@section('panel-headLinks')
    <link href="{{ asset('/plugins/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/new_record_panel.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/records/validation_errors.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/record_form.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/records/social_folder_form.css') }}" rel="stylesheet" type="text/css">
@stop

@section('main-window-content')

    @include('partials.select-panel')

    @if (count($errors) > 0 || Session::has('flash_message'))
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @else
        @if(isset($success) and $success != null)
        <div class="alert alert-success">
            <ul>
                <li>{{ $success }}</li>
            </ul>
        </div>
        @endif
    @endif

    @include('partials.forms.social_folder_form')
@stop

@section('panel-scripts')
    <script src="{{ asset('/bootstrap-3.3.6/js/modal.js') }}"></script>
    <script src="{{ asset('/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{asset('js/records/selectEditRecordInMainPanel.js')}}"></script>
    <script src="{{ asset('js/records/custom_datepicker.js') }}"></script>
    <script src="{{asset('js/forms.js')}}"></script>
    <script src="{{asset('js/records/social_folder.js')}}"></script>
@stop
