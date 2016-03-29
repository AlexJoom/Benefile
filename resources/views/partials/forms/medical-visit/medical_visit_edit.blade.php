@extends('layouts.mainPanel')

@section('panel-title')
    Επεξεργασία Ιατρικής επίσκεψης
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
        $p = "partials/forms/new_medical_visit_form.";
    ?>
    {{--@include('partials.select-panel')--}}

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="padding-left-right-15">
     {{--edit-visit">--}}
        <h1 class="record-section-header">@lang($p.'edit-visit')</h1>
    </div>
    {{--------------- 1. GENERAL DETAILS  (Info that comes from BASIC INFO) ---------------}}
    <!-- ACCESS LEVEL -->
    @if (Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 2)
    <div class="form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. @lang($p."personal_info")</h1>
        </div>
        <div class="row padding-top-20">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15 float-left">
                            {!! Form::label('folder_number', Lang::get($p.'folder_number')) !!}
                            {!! Form::text('folder_number', $benefiter->folder_number, array('class' => 'custom-input-text text-align-right' , 'disabled')) !!}
                        </div>
                        {{--<div class="form-group padding-left-right-15 float-left">--}}
                            {{--{!! Form::label('medical_visit_id', Lang::get($p.'total_visits_number')) !!}--}}
                            {{--{!! Form::text('medical_visit_id', $medical_visits_number, array('class' => 'custom-input-text text-align-right' , 'disabled')) !!}--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- LASTNAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('lastname', Lang::get($p.'lastname')) !!}
                            {!! Form::text('lastname', $benefiter->lastname, array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                        {{--NAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('name', Lang::get($p.'name')) !!}
                            {!! Form::text('name', $benefiter->name, array('class' => 'custom-input-text' , 'disabled')) !!}
                        </div>
                        {{-- GENDER --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('gender_id', Lang::get($p.'gender')) !!}
                            <div class="make-inline">
                                <?php
                                    $male = false;
                                    $female = false;
                                    if($benefiter->gender_id == 2){
                                        $female = true;
                                    } else {
                                        $male = true;
                                    }
                                ?>
                                <div class="make-inline">
                                    {!! Form::radio('gender_id', 1, $male, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                    {!! Form::label('gender_id', Lang::get('basic_info_form.male'), array('class' => 'radio-value')) !!}
                                    {!! Form::radio('gender_id', 2, $female, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                    {!! Form::label('gender_id', Lang::get('basic_info_form.female'), array('class' => 'radio-value')) !!}
                                </div>
                            </div>
                        </div>
                        {{-- DATE OF BIRTH --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('birth_date', Lang::get($p.'birth_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('birth_date', $benefiter->birth_date, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- FATHERS NAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('fathers_name', Lang::get($p.'fathers_name')) !!}
                            {!! Form::text('fathers_name', $benefiter->fathers_name, array('class' => 'custom-input-text' , 'disabled')) !!}
                        </div>
                        {{-- MOTHERS NAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('mothers_name', Lang::get($p.'mothers_name')) !!}
                            {!! Form::text('mothers_name', $benefiter->mothers_name, array('class' => 'custom-input-text' , 'disabled')) !!}
                        </div>
                        {{-- NATIONALITY --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('nationality_country', Lang::get($p.'nationality')) !!}
                            {!! Form::text('nationality_country', $benefiter->nationality_country, array('class' => 'custom-input-text' , 'disabled')) !!}
                        </div>
                        {{-- ORIGIN COUNTRY --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('origin_country', Lang::get('basic_info_form.origin_country')) !!}
                            {!! Form::text('origin_country', $benefiter->origin_country, array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- ARRIVAL DATE --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('arrival_date', Lang::get($p.'arrival_date')) !!}
                            {!! Form::text('arrival_date', $benefiter->arrival_date, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}
                        </div>
                        {{-- TELEPHONE --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('telephone', Lang::get('basic_info_form.telephone')) !!}
                            <?php
                                if($benefiter->telephone == 0){
                                    $benefiter->telephone = "";
                                }
                            ?>
                            {!! Form::text('telephone', $benefiter->telephone, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        {{-- ADDRESS --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('address', Lang::get('basic_info_form.address')) !!}
                            {!! Form::text('address', $benefiter->address, array('class' => 'custom-input-text address', 'disabled' => 'disabled')) !!}
                        </div>

                        {{-- ETHNICITY --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('ethnic_group', Lang::get('basic_info_form.ethnic_group')) !!}
                            {!! Form::text('ethnic_group', $benefiter->ethnic_group, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>

                        {{-- ENTRY POINT --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">--}}
                            {{--{!! Form::label('travel_route', Lang::get($p.'travel_route')) !!}--}}
                            {{--{!! Form::text('travel_route', $benefiter->travel_route, array('class' => 'custom-input-text' , 'disabled')) !!}--}}
                        {{--</div>--}}
                        {{-- DURATION OF TRAVEL --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">--}}
                            {{--{!! Form::label('travel_duration', Lang::get($p.'travel_duration')) !!}--}}
                            {{--{!! Form::text('travel_duration', $benefiter->travel_duration, array('class' => 'custom-input-text' , 'disabled')) !!}--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="edit-medical-visit" class="basic-info-form">
        {!! Form::model($benefiter, array('url' => 'benefiter/'.$benefiter->id.'/editMedicalVisit', 'files'=>true, 'id'=>'medical_visit_submit')) !!}
            {{-- get the benefiter id --}}
            {!! Form::hidden('benefiter_id', $benefiter->id) !!}
            {{-- get the doctor id --}}
            {!! Form::hidden('doctor_id', $doctor_id) !!}
            {{-- get medical visit id --}}
            {!! Form::hidden('selected_medical_visit_id', $selected_medical_visit_id) !!}

            {{-- BASIC MEDICAL DETAILS --}}
            <div class="form-section no-bottom-border">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">3. @lang($p.'medical_info')</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{-- general medical info --}}
                        <div class="row">
                            <div class="padding-left-right-15">
                                {{-- ΟΝΟΜΑ ΙΑΤΡΟΥ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                    {!! Form::label('doctor_name', Lang::get($p.'doctor_name')) !!}
                                    {!! Form::text('doctor_name', $med_visit_doctor, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                                </div>
                                {{-- ΗΜΕΡ. ΕΞΕΤΑΣΗΣ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                    {!! Form::label('examination_date', Lang::get($p.'exam_date')) !!} <i class="fa fa-asterisk asterisk"></i>
                                    {!! Form::text('examination_date', $med_visit_date, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                                </div>
                                {{-- ΤΟΠΟΘΕΣΙΑ ΕΞΕΤΑΣΗΣ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                                    {!! Form::label('medical_location_id', Lang::get($p.'exam_location')) !!}
                                    {!! Form::select('medical_location_id', $medical_locations_array, $med_visit_location_id) !!}
                                </div>
                                {{-- ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                                    {!! Form::label('medical_incident_id', Lang::get($p.'incident_type')) !!}
                                    {!! Form::select('medical_incident_id', $medical_incident_type_array, $med_visit_incident_type_id) !!}
                                </div>
                                {{-- ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ - ΠΕΡΙΣΤΑΤΙΚΟ --}}
                                {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">--}}
                                    {{--{!! Form::label('incident_type_text', 'ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ') !!}--}}
                                    {{--{!! Form::textarea('incident_type_text', null, ['size' => '30x3']) !!}--}}
                                {{--</div>--}}
                            </div>
                        </div>

                        <hr>
                        {{-- main medical info --}}
                        <div id="chronic-cond" class="row padding-bottom-30">
                            {{-- Fetch the posted input values if the post fails --}}
                            @if(!empty($med_visit_chronic_conditions) && count($med_visit_chronic_conditions) !=0)
                                @for($i=0; $i< count($med_visit_chronic_conditions) ; $i++)
                                    <div  class="padding-left-right-15 @if($i==0) chronicConditions @endif @if($i!=0) condition-added-div @endif">
                                        <div class="form-group float-left width-100-percent">
                                            {{-- ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ --}}
                                            <div class="make-inline col-md-6">
                                            {{-- if post fail then reprint what was entered in the fields --}}
                                                {!! Form::label('chronic_conditions', Lang::get($p.'chronic_conditions')) !!}
                                                {!! Form::text('chronic_conditions[]', $med_visit_chronic_conditions[$i]['description'], array('id'=>'chronCon', 'class' => 'custom-input-text display-inline')) !!}
                                                {{-- add --}}
                                                <a class="color-green add-condition" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                                </a>
                                                {{-- remove --}}
                                                <a class="color-red remove-condition @if($i == 0) hide-element @endif" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @else
                                <div  class="padding-left-right-15 chronicConditions">
                                    <div class="form-group float-left width-100-percent">
                                        {{-- ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ --}}
                                        <div class="make-inline col-md-6">
                                        {{-- if post fail then reprint what was entered in the fields --}}
                                            {!! Form::label('chronic_conditions', Lang::get($p.'chronic_conditions')) !!}
                                            {!! Form::text('chronic_conditions[]', null, array('id'=>'chronCon', 'class' => 'custom-input-text display-inline')) !!}
                                            {{-- add --}}
                                            <a class="color-green add-condition" href="javascript:void(0)">
                                                <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                            </a>
                                            {{-- remove --}}
                                            <a class="color-red remove-condition hide-element" href="javascript:void(0)">
                                                <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>
                        {{-- physical examinations --}}
                        <div class="row">
                            <div class="padding-left-right-15">
                                {{-- ΥΨΟΣ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                    {!! Form::label('height', Lang::get($p.'height')) !!}
                                    {!! Form::text('height', $med_visit_height, array('class' => 'custom-input-text')) !!}
                                </div>
                                {{-- ΒΑΡΟΣ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                    {!! Form::label('weight', Lang::get($p.'weight')) !!}
                                    {!! Form::text('weight', $med_visit_weight, array('class' => 'custom-input-text')) !!}
                                </div>
                                {{-- ΘΕΡΜΟΚΡΑΣΙΑ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                                    {!! Form::label('temperature', Lang::get($p.'temperature')) !!}
                                    {!! Form::text('temperature', $med_visit_temperature, array('class' => 'custom-input-text')) !!}
                                </div>
                                {{-- ΑΡΤΗΡΙΑΚΗ ΠΙΕΣΗ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                                    {!! Form::label('blood_pressure', Lang::get($p.'blood_pressure')) !!}
                                    {!! Form::text('blood_pressure_systolic', $med_visit_blood_pressure_systolic, array('class' => 'custom-input-text display-inline width-30-percent','placeholder'=>Lang::get($p.'systolic'))) !!}
                                    {!! Form::text('blood_pressure_diastolic', $med_visit_blood_pressure_diastolic, array('class' => 'custom-input-text display-inline width-30-percent','placeholder'=>Lang::get($p.'diastolic'))) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="padding-left-right-15">
                                {{-- ΠΕΡΙΜΕΤΡΟΣ ΚΡΑΝΙΟΥ (για νεογέννητα) --}}
                                <div class="form-group make-inline padding-left-right-15 float-left col-md-4">
                                    {!! Form::label('skull_perimeter', Lang::get($p.'skull_perimeter')) !!}
                                    {!! Form::text('skull_perimeter', $med_visit_skull_perimeter, array('class' => 'custom-input-text')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CLINICAL RESULTS --}}
            <div class="form-section no-bottom-border" id="clinical-results-div" data-placeholder-name="@lang($p."condition")">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">4. @lang($p.'clinical_results')</h1>
                </div>
                @for($i=0; $i<count($ExamResultsLookup) ; $i++)
                    {{--@if(!empty($med_visit_exam_results) )--}}
                        <div class="row padding-left-right-30 padding-top-bottom-15">
                            <div class="form-group padding-left-right-15 margin-right-30 float-left col-md-8 clinical-results" id="select-condition-{{$i}}">
                                {!! Form::label('examResultLoukup[{{$i}}][]', $ExamResultsLookup[$i]['description'].':', array('class' => 'display-block width-270 max-width-none')) !!}
                                <select id="clinical-select-{{$i}}" class="js-example-basic-multiple" multiple="multiple" name="examResultLoukup[{{$i}}][]" style="width:100%;">
                                    <?php $with_select_options = false;?>
                                    @for($j=0; $j<count($med_visit_exam_results); $j++)
                                        @if(!empty($med_visit_exam_results[$j]['results_lookup_id']) && $med_visit_exam_results[$j]['results_lookup_id'] == $ExamResultsLookup[$i]['id'])
                                            <option selected="selected" value="{{$med_visit_exam_results[$j]['icd10_id']}}" >{{$med_visit_exam_results[$j]['icd10']['code']}}: {{$med_visit_exam_results[$j]['icd10']['description']}}</option>
                                            <?php $with_select_options = true;?>
                                        @endif
                                    @endfor

                                    @if($with_select_options == false)
                                        <option selected="selected" style="display: none"></option>
                                    @endif
                                </select>
                                <?php $duplicity_counter = 0; ?>
                                @for($j=0; $j<count($med_visit_exam_results); $j++)
                                    @if($duplicity_counter < 1 && $med_visit_exam_results[$j]['results_lookup_id'] == $ExamResultsLookup[$i]['id'])
                                        @if(!empty($med_visit_exam_results[$j]['description']))
                                        {!! Form::textarea('examResultDescription[]', $med_visit_exam_results[$j]['description'], ['size' => '35x5', 'class'=>'custom-input-textarea margin-top-20 width-100-percent max-width-100per']) !!}
                                        @else
                                        {!! Form::textarea('examResultDescription[]', $med_visit_exam_results[$j]['description'], ['size' => '35x5', 'class'=>'custom-input-textarea margin-top-20 width-100-percent max-width-100per', 'style' => 'display: none;']) !!}
                                        @endif
                                        <?php $duplicity_counter++; ?>
                                    @endif
                                @endfor

                                @if($duplicity_counter ==0)
                                    {!! Form::textarea('examResultDescription[]', null, ['size' => '35x5', 'class'=>'margin-top-20 width-100-percent max-width-100per custom-input-textarea', 'style' => 'display: none;']) !!}
                                @endif
                            </div>
                        </div>
                    {{--@else--}}
                    {{--@for($i=0; $i<count($ExamResultsLookup) ; $i++)--}}
                        {{--<div class="row padding-left-right-30 padding-top-bottom-15">--}}
                            {{--<div class=" form-group padding-left-right-15 margin-right-30 float-left col-md-8 clinical-results" id="select-condition">--}}
                                {{--{!! Form::label('examResultLoukup[]', $ExamResultsLookup[$i]['description'].':', array('class' => 'display-block width-270 max-width-none')) !!}--}}
                                {{--<select id="clinical-select-{{$i}}" class="js-example-basic-multiple" multiple="multiple" name="examResultLoukup[{{$i}}][]" style="width:100%;">--}}
                                    {{--<option selected="selected" style="display: none"></option>--}}
                                {{--</select>--}}
                                {{--{!! Form::textarea('examResultDescription[]', null, ['size' => '35x5', 'class'=>'margin-top-20 width-100-percent max-width-100per custom-input-textarea']) !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}
                     {{--@endfor--}}
                    {{--@endif--}}
                @endfor
            </div>

            {{-- LABORATORY RESULTS --}}
            <div class="form-section no-bottom-border">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">5. @lang($p.'lab_results')</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="lab-result" class="row padding-bottom-30">
                            @if(!empty($med_visit_lab_results) && count($med_visit_lab_results) !=0)
                                @for($i=0 ; $i<count($med_visit_lab_results) ; $i++)
                                    <div class="padding-left-right-15 @if($i==0) lab-results @endif @if($i!=0) lab-added-div @endif">
                                        <div class="form-group float-left width-100-percent">
                                            {{-- ΕΡΓΑΣΤΗΡΙΑΚΑ ΑΠΟΤΕΛΕΣΜΑΤΑ --}}
                                            <div class="make-inline col-md-10">
                                                {!! Form::label('lab_results', Lang::get($p.'lab_results_info')) !!}
                                                {!! Form::text('lab_results[]', $med_visit_lab_results[$i]['laboratory_results'], array('id'=>'labRes', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                                {{-- add --}}
                                                <a class="color-green add-lab-result" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                                </a>
                                                {{-- remove --}}
                                                <a class="color-red remove-lab-result @if($i == 0) hide-element @endif" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @else
                                <div class="padding-left-right-15 lab-results">
                                    <div class="form-group float-left width-100-percent">
                                        {{-- ΕΡΓΑΣΤΗΡΙΑΚΑ ΑΠΟΤΕΛΕΣΜΑΤΑ --}}
                                        <div class="make-inline col-md-10">
                                            {!! Form::label('lab_results', Lang::get($p.'lab_results_info')) !!}
                                            {!! Form::text('lab_results[]', null, array('id'=>'labRes', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                            {{-- add --}}
                                            <a class="color-green add-lab-result" href="javascript:void(0)">
                                                <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                            </a>
                                            {{-- remove --}}
                                            <a class="color-red remove-lab-result hide-element" href="javascript:void(0)">
                                                <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- MEDICATION DETAILS --}}
            <div class="form-section no-bottom-border">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">6. @lang($p.'medication')</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="medication" class="row padding-bottom-30">
                            <div  class="padding-left-right-15">
                                <div class="medicinal-instructions row padding-bottom-30">
                                    <div class="col-md-12">
                                        <div  class="padding-left-right-15">
                                            <i class="fa fa-exclamation-triangle color-orange"></i> <span class="make-italic">@lang($p."medicinal_instructions")</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($med_visit_medication) && count($med_visit_medication) !=0)
                                @for($i=0 ; $i<count($med_visit_medication) ; $i++)
                                    <div class="padding-left-right-15 @if($i==0) medicationList @endif @if($i!=0) med-added-div @endif">
                                        <div class="row">
                                            <div class="form-group float-left col-md-12">
                                                 {{--ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ--}}
                                                <div class="select-lists make-inline col-md-6">
                                                    {!! Form::label('medication_name_from_lookup[]', Lang::get($p.'medication_info')) !!}
                                                    {{--{!! Form::select('medication_name_from_lookup[]', [], '', array('id'=>'medicinal_name_1', 'class'=>'js-example-basic-multiple', 'style'=>'width:30%;')) !!}--}}
                                                    <select id="medicinal_name_{{$i+1}}" class="js-example-basic-multiple " name="medication_name_from_lookup[]">
                                                        {{--@if(!empty($medication_name_from_lookup_session[$i]) && $medication_name_from_lookup_session[$i] != -1 ))--}}
                                                            <option selected="selected" value="{{$med_visit_medication[$i]['medication_lookup_id']}}" >{{$med_visit_medication[$i]['medical_medication_lookup']['description']}}</option>
                                                        {{--@endif--}}
                                                    </select>
                                                </div>
                                                {{--Description--}}
                                                <div class="medication_other_name col-md-6">
                                                    {{--{!! Form::label('medication_new_name[]') !!}--}}
                                                    {!! Form::text('medication_new_name[]', null, array('class' => 'custom-input-text display-inline width-100-percent', 'placeholder' => Lang::get($p.'medicinal_name'))) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div  class="padding-left-right-15">
                                                <div class="form-group float-left col-md-6 padding-left-50px">
                                                    {{-- Dosage --}}
                                                    {!! Form::text('medication_dosage[]', $med_visit_medication[$i]['dosage'], array('class' => 'custom-input-text display-inline', 'placeholder' => Lang::get($p.'medicinal_dosage'))) !!}

                                                    {{-- Duration --}}
                                                    {!! Form::text('medication_duration[]', $med_visit_medication[$i]['duration'], array('class' => 'custom-input-text display-inline', 'placeholder' => Lang::get($p.'medicinal_duration'))) !!}
                                                </div>
                                                <div class="form-group float-left col-md-3">
                                                    {{-- Supplied from PRAKSIS --}}
                                                    {!! Form::label('supply_from_praksis[]', Lang::get($p.'supply_from_praksis'), array('class' => 'radio-value margin-right-10px')) !!}
                                                    {!! Form::hidden('supply_from_praksis_hidden[]', $med_visit_medication[$i]['supply_from_praksis'], array('class'=>'supply_from_praksis_hidden'))!!}
                                                    @if($med_visit_medication[$i]['supply_from_praksis'] != 0)
                                                        {{--{!! Form::checkbox('supply_from_praksis[]', "$supply_from_praksis_hidden_session[$i]", true, array('class'=>'supply_from_praksis make-inline')) !!}--}}
                                                        <input name="supply_from_praksis[]" class="supply_from_praksis make-inline" type="checkbox" value="$supply_from_praksis_hidden_session[$i]" checked>
                                                    @else
                                                        {{--{!! Form::checkbox('supply_from_praksis[]', "$supply_from_praksis_hidden_session[$i]", false, array('class'=>'supply_from_praksis make-inline')) !!}--}}
                                                         <input name="supply_from_praksis[]" class="supply_from_praksis make-inline" type="checkbox" value="$supply_from_praksis_hidden_session[$i]">
                                                    @endif
                                                    {{--add--}}
                                                    @if($i==0)
                                                        <a id="add-medicine" class="color-green add-med" href="javascript:void(0)">
                                                            <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                                        </a>
                                                    @endif
                                                     {{--remove--}}
                                                    <a id="remove-medicine" class="color-red remove-med @if($i == 0) hide-element @endif" href="javascript:void(0)">
                                                        <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @else
                                <div  class="padding-left-right-15 medicationList">
                                    <div class="row">
                                        <div class="form-group col-md-12 float-left">
                                            {{-- ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ --}}
                                            <div class="select-lists make-inline col-md-6">
                                                {!! Form::label('medication_name_from_lookup[]', Lang::get($p.'medication_info')) !!}
                                                {{--{!! Form::select('medication_name_from_lookup[]', [], '', array('id'=>'medicinal_name_1', 'class'=>'js-example-basic-multiple', 'style'=>'width:30%;')) !!}--}}
                                                <select id="medicinal_name_1" class="js-example-basic-multiple " name="medication_name_from_lookup[]">
                                                    <option value="-1" selected="selected">Επιλέξτε αγωγή</option>
                                                </select>
                                            </div>
                                            {{-- Description --}}
                                            <div class="medication_other_name col-md-6">
                                                {!! Form::text('medication_new_name[]', null, array('class' => 'custom-input-text display-inline width-100-percent', 'placeholder' => Lang::get($p.'medicinal_name'))) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="padding-left-right-15">
                                            <div class="form-group float-left col-md-6 padding-left-50px">
                                                {!! Form::text('medication_dosage[]', null, array('class' => 'custom-input-text display-inline', 'placeholder' => Lang::get($p.'medicinal_dosage'))) !!}
                                                {!! Form::text('medication_duration[]', null, array('class' => 'custom-input-text display-inline', 'placeholder' => Lang::get($p.'medicinal_duration'))) !!}
                                            </div>
                                            <div class="form-group float-left col-md-3">
                                                {!! Form::label('supply_from_praksis[]', Lang::get($p.'supply_from_praksis'), array('class' => 'radio-value margin-right-10px')) !!}
                                                {!! Form::hidden('supply_from_praksis_hidden[]', 0, array('class'=>'supply_from_praksis_hidden'))!!}
                                                {!! Form::checkbox('supply_from_praksis[]', 1, false, array('class'=>'supply_from_praksis make-inline')) !!}

                                                {{-- add --}}
                                                <a id="add-medicine" class="color-green add-med" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                                </a>
                                                {{-- remove --}}
                                                <a id="remove-medicine" class="color-red remove-med hide-element" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- REFERRALS --}}
            <div class="form-section no-bottom-border">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">7. @lang($p.'referrals')</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="referrals" class="row padding-bottom-30">
                            @if(!empty($med_visit_referrals) && count($med_visit_referrals) !=0)
                                @for($i=0; $i<count($med_visit_referrals) ; $i++)
                                    <div class="padding-left-right-15 @if($i==0) referral @endif @if($i!=0) ref-added-div @endif">
                                        <div class="form-group float-left width-100-percent">
                                            {{-- ΠΑΡΑΠΟΜΠΗ --}}
                                            <div class="make-inline col-md-10">
                                                {!! Form::label('referrals', Lang::get($p.'referrals_info')) !!}
                                                {!! Form::text('referrals[]', $med_visit_referrals[$i]['referrals'], array('id'=>'refList', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                                {{-- add --}}
                                                <a class="color-green add-ref" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                                </a>
                                                {{-- remove --}}
                                                <a class="color-red remove-ref @if($i == 0) hide-element @endif" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @else
                                <div class="padding-left-right-15 referral">
                                    <div class="form-group float-left width-100-percent">
                                        {{-- ΠΑΡΑΠΟΜΠΗ --}}
                                        <div class="make-inline col-md-10">
                                            {!! Form::label('referrals', Lang::get($p.'referrals_info')) !!}
                                            {!! Form::text('referrals[]', null, array('id'=>'refList', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                            {{-- add --}}
                                            <a class="color-green add-ref" href="javascript:void(0)">
                                                <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                            </a>
                                            {{-- remove --}}
                                            <a class="color-red remove-ref hide-element" href="javascript:void(0)">
                                                <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- UPLOAD FILE --}}
            <div class="form-section no-bottom-border">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">8. @lang($p.'upload_file')</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="upload_file">
                            @if(!empty($med_visit_uploads) && count($med_visit_uploads)!=0)
                                @for($i=0 ; $i<count($med_visit_uploads) ; $i++)
                                    <div class="@if($i==0) uploadFile @endif @if($i!=0) file-added-div @endif">
                                        <div class="row">
                                            <div class="padding-left-right-15">
                                                {{-- ΑΝΕΒΑΣΜΑ ΑΡΧΕΙΟΥ --}}
                                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-8">
                                                    {!! Form::label('upload_file_title', Lang::get($p.'file_details')) !!}
                                                    {!! Form::text('upload_file_description[]', $med_visit_uploads[$i]['description'], array('id'=>'file', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                                    {{-- add --}}
                                                    <a class="color-green add-file @if($i != 0) hide-element @endif" href="javascript:void(0)">
                                                        <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                                    </a>
                                                    {{-- remove --}}
                                                    <a class="color-red remove-file @if($i == 0) hide-element @endif" href="javascript:void(0)">
                                                        <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="padding-left-right-15">
                                                {{--@if(!empty($med_visit_uploads[$i]['title']))--}}
                                                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-4 saved-file">
                                                        {{ $med_visit_uploads[$i]['title'] }} &nbsp; &nbsp; <a href="javascript:void(0)"><i class="glyphicon glyphicon-remove color-red remove-uploaded-file"></i></a>
                                                    </div>
                                                {{--@else--}}
                                                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-4 new-upload-file">
                                                        {!! Form::file('upload_file_title[]', null, array('class' => 'custom-input-text')) !!}
                                                    </div>
                                                {{--@endif--}}
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @else
                                <div class="uploadFile">
                                    <div class="row">
                                        <div class="padding-left-right-15">
                                            {{-- ΑΝΕΒΑΣΜΑ ΑΡΧΕΙΟΥ --}}
                                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-8">
                                                {!! Form::label('upload_file_title', Lang::get($p.'file_details')) !!}
                                                {!! Form::text('upload_file_description[]', null, array('id'=>'file', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                                {{-- add --}}
                                                <a class="color-green add-file" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                                </a>
                                                {{-- remove --}}
                                                <a class="color-red remove-file hide-element" href="javascript:void(0)">
                                                    <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="padding-left-right-15">
                                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-4">
                                                {!! Form::file('upload_file_title[]', null, array('class' => 'custom-input-text')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="form-section align-text-center">
                {!! Form::submit(Lang::get($p.'update_medical_visit'), array('class' => 'submit-button')) !!}
            </div>
        {!! Form::close() !!}
        {{--</div>--}}
    </div>
    @endif


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
    <script src="{{asset('js/forms.js')}}"></script>
    <script src="{{asset('js/records/medical_visit.js')}}"></script>
@stop






