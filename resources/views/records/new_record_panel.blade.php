@extends('layouts.mainPanel')

@section('panel-title')
    Users
@stop

@section('panel-headLinks')
    <link href={{asset('css/records/new_record_panel.css')}} rel="stylesheet" type="text/css">
    @yield('css')
@stop

@section('main-window-content')

    {{-- actions refering to records --}}

    <div class="no-margin light-green-background width-100-percent" id="actions">
    {{--<div style="width: 100%; background-color: red;">--}}
        <div class="row width-100-percent">
            <div class="col-md-3 record-panel-title">
                <a class="white" href="{{ url('/main-panel/basic-info') }}">ΒΑΣΙΚΑ ΣΤΟΙΧΕΙΑ</a>
            </div>

            <div class="col-md-3 record-panel-title">
                <a class="white" href="#">ΙΑΤΡΙΚΟΣ ΦΑΚΕΛΟΣ</a>
            </div>

            <div class="col-md-3 record-panel-title">
                <a class="white" href="#">ΝΟΜΙΚΟΣ ΦΑΚΕΛΟΣ</a>
            </div>

            <div class="col-md-3 record-panel-title">
                <a class="white" href="#">ΚΟΙΝΩΝΙΚΟΣ ΦΑΚΕΛΟΣ</a>
            </div>
        </div>
        {{-- The abone three options will be removed in order to be added dynamically from another view. --}}

    </div>

    @yield('view-content')
@stop

@section('panel-scripts')
    <script src="{{asset('js/main-panel/users-list.js')}}"></script>
@stop
