@extends('layouts.mainPanel')

@section('title')
    Users
@stop

@section('panel-headLinks')
    <link href={{asset('css/main-panel/users-list.css')}} rel="stylesheet" type="text/css">
@stop

@section('main-window-content')

    {{-- actions refering to users --}}
    <div class="no-margin light-green-background pos-relative height-8per" id="actions">
        <div class="col-md-3">
            <a class="white">ΒΑΣΙΚΑ ΣΤΟΙΧΕΙΑ</a>
        </div>

        <div class="col-md-3">
            <a class="white">ΙΑΤΡΙΚΟΣ ΦΑΚΕΛΟΣ</a>
        </div>

        <div class="col-md-3">
            <a class="white">ΝΟΜΙΚΟΣ ΦΑΚΕΛΟΣ</a>
        </div>

        <div class="col-md-3">
            <a class="white">ΚΟΙΝΩΝΙΚΟΣ ΦΑΚΕΛΟΣ</a>
        </div>
        {{-- The abone three options will be removed in order to be added dynamically from another view. --}}

    </div>

    @yield('view-content')
@stop

@section('panel-scripts')
    <script src="{{asset('js/main-panel/users-list.js')}}"></script>
@stop
