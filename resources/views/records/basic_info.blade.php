@extends('records.new_record_panel')

@section('css')
    <link href="{{asset('css/records/basic_info.css')}}" rel="stylesheet" type="text/css">
@stop

@section('view-content')
    @include('partials.forms.basic_info_form')
@stop

@section('js')
    <script src="{{asset('js/records/basic_info.js')}}"></script>
@stop
