@extends('layouts.mainPanel')

@section('panel-title')
    Νέος Ωφελούμενος
@stop

@section('panel-headLinks')
    <link href="{{ asset('/plugins/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/uploadExcel/dropzone.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/new_record_panel.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/records/validation_errors.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/record_form.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('select2-4.0.2-rc.1/css/select2.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('main-window-content')

    <?php
        $tab = "medical";
        $p = "partials/forms/new_medical_visit_form.";
    ?>
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


    @include('partials.forms.new_medical_visit')
@stop

@section('panel-scripts')
    <script src="{{asset('select2-4.0.2-rc.1/js/select2.full.js')}}"></script>
    {{-- select new record in side-panel if you are creating a new benefiter's basic info... --}}
    @if($benefiter->id == -1)
    <script src="{{ asset('js/records/selectNewRecordInMainPanel.js') }}"></script>
    {{-- ...else select the edit benefiter option --}}
    @else
    <script src="{{asset('js/records/selectEditRecordInMainPanel.js')}}"></script>
    @endif
    <script src="{{asset('/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/records/custom_datepicker.js') }}"></script>
    <script src="{{asset('js/records/basic_info.js')}}"></script>
    <script src="{{asset('js/records/medical_visit.js')}}"></script>
@stop
