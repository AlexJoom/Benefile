@extends('records.new_record_panel')

@section('css')
    <link href={{asset('css/records/basic_info.css')}} rel="stylesheet" type="text/css">
@stop

@section('view-content')
    @include('partials.forms.basic_info_form')
@stop
