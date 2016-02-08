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
        <div class="col-md-4">
            <a class="white">Προς ενεργοποιηση</a>
        </div>

        <div class="col-md-4">
            <a class="white">Ενεργοποιημενοι</a>
        </div>

        <div class="col-md-4">
            <a class="white">Απενεργοποιημενοι</a>
        </div>
        {{-- The abone three options will be removed in order to be added dynamically from another view. --}}

    </div>

    {{-- columns with details --}}
    <div class="no-margin pos-relative height-6per grey-border-bottom" id="details">

        <div class="col-md-3">
            <a class="grey">Ονομα</a>
        </div>

        <div class="col-md-3">
            <a class="grey">Επιθετο</a>
        </div>

        <div class="col-md-3">
            <a class="grey">Ρολος</a>
        </div>

        <div class="col-md-3">
            <a class="grey">Ημ. Εγγραφης</a>
        </div>
        {{-- The abone three options will be removed in order to be added dynamically from another view. --}}
    </div>

    {{-- results list --}}
    <div class="no-margin pos-relative" id="header">
    </div>

@stop

@section('panel-scripts')
    <script src="{{asset('js/main-panel/users-list.js')}}"></script>
@stop