@extends('layouts.mainPanel')

@section('panel-title')
    Νέος Ωφελούμενος
@stop

@section('panel-headLinks')
    <link href="{{ asset('/plugins/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/new_record_panel.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/basic_info.css')}}" rel="stylesheet" type="text/css">
@stop

@section('main-window-content')

    {{-- actions refering to records --}}

    <?php
        /* check which tab is selected */
        $basic_selected = '';
        $medical_selected = '';
        $legal_selected = '';
        $social_selected = '';
        if(isset($tab)){
            if($tab === "medical"){
                $medical_selected = 'selected';
            } else if($tab === "legal"){
                $legal_selected = 'selected';
            } else if($tab === "social"){
                $social_selected = 'selected';
            }
        } else {
            $basic_selected = 'selected';
        }
    ?>

    <div class="no-margin light-green-background width-100-percent" id="actions">
    {{--<div style="width: 100%; background-color: red;">--}}
        <div class="row width-100-percent">
            <div class="col-md-3 record-panel-title">
                <a class="white {{ $basic_selected }}" href="{{ url('/new-benefiter/basic-info') }}">ΒΑΣΙΚΑ ΣΤΟΙΧΕΙΑ</a>
            </div>

            <div class="col-md-3 record-panel-title">
                <a class="white {{ $medical_selected }}" href="">ΙΑΤΡΙΚΟΣ ΦΑΚΕΛΟΣ</a>
            </div>

            <div class="col-md-3 record-panel-title">
                <a class="white {{ $legal_selected }}" href="">ΝΟΜΙΚΟΣ ΦΑΚΕΛΟΣ</a>
            </div>

            <div class="col-md-3 record-panel-title">
                <a class="white {{ $social_selected }}" href="">ΚΟΙΝΩΝΙΚΟΣ ΦΑΚΕΛΟΣ</a>
            </div>
        </div>
        {{-- The abone three options will be removed in order to be added dynamically from another view. --}}

    </div>

    @include('partials.forms.basic_info_form')
@stop

@section('panel-scripts')
    <script src="{{ asset('/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/records/selectNewRecordInMainPanel.js') }}"></script>
    <script src="{{asset('js/records/basic_info.js')}}"></script>
@stop
