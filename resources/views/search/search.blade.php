<?php
    $p = 'search/search.';
?>
@extends('layouts.mainPanel')

@section('panel-title')
    @lang('layouts/mainPanel.search')
@stop

@section('panel-headLinks')
    <link href="{{ asset('/plugins/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/records/validation_errors.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/records/record_form.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/search/search.css')}}" rel="stylesheet" type="text/css">
@stop

@section('main-window-content')
    <div class="personal-info form-section">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">@lang($p."search_parameters")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(array('url' => 'results', 'id' => 'search-form', 'method' => 'get')) !!}
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('folder_number', Lang::get('basic_info_form.folder_number')) !!}
                            {!! Form::text('folder_number', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('lastname', Lang::get('basic_info_form.lastname')) !!}
                            {!! Form::text('lastname', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('name', Lang::get('basic_info_form.name')) !!}
                            {!! Form::text('name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('fathers_name', Lang::get('basic_info_form.fathers_name')) !!}
                            {!! Form::text('fathers_name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                            {!! Form::label('gender_id', Lang::get('basic_info_form.gender')) !!}
                            <div>
                                {!! Form::radio('gender_id', 1, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender_id', Lang::get('basic_info_form.male'), array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender_id', 2, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender_id', Lang::get('basic_info_form.female'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('telephone', Lang::get('basic_info_form.telephone')) !!}
                            {!! Form::text('telephone', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label(Lang::get('basic_info_form.birth_date')) !!}
                            <div>
                                {!! Form::text('birth_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('origin_country', Lang::get('basic_info_form.origin_country')) !!}
                            {!! Form::text('origin_country', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                            {!! Form::label('medical_location_id', Lang::get('partials/forms/new_medical_visit_form.exam_location')) !!}
                            <div>
                                <select name="medical_location_id">
                                    <option value=0></option>
                                    <?php
                                        if(isset($medical_locations) and $medical_locations != null){
                                            foreach($medical_locations as $location){
                                                echo "<option value=" . $location->id . ">" . $location->description . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="padding-left-right-15">
                {!! Form::submit(Lang::get('layouts/mainPanel.search'), array('class' => 'simple-button', 'id' => 'search-btn')) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div id="search-results" class="form-section hide">
    </div>
@stop

@section('panel-scripts')
    <script src="{{asset('js/main-panel/selectSearchInMainPanel.js')}}"></script>
    <script src="{{ asset('/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/records/custom_datepicker.js') }}"></script>
    <script src="{{asset('js/forms.js')}}"></script>
    <script src="{{ asset('js/search/search.js') }}"></script>
@stop