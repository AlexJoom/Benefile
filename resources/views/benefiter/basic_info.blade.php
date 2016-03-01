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
    @else
        @if(isset($success) and $success != null)
        <div class="alert alert-success">
            <ul>
                <li>{{ $success }}</li>
            </ul>
        </div>
        @endif
    @endif

    @include('partials.forms.basic_info_form')
@stop

@section('panel-scripts')
    <script src="{{ asset('/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    {{-- select new record in side-panel if you are creating a new benefiter's basic info... --}}
    @if($benefiter->id == -1)
    <script src="{{ asset('js/records/selectNewRecordInMainPanel.js') }}"></script>
    {{-- ...else select the edit benefiter option --}}
    @else
    <script src="{{asset('js/records/selectEditRecordInMainPanel.js')}}"></script>
    @endif
    <script src="{{ asset('js/records/custom_datepicker.js') }}"></script>
    <script src="{{asset('js/forms.js')}}"></script>
    <script src="{{asset('js/records/basic_info.js')}}"></script>
@stop
