<?php
    $p = "partials/forms/new_medical_visit_form.";
?>


{{-- 1. GENERAL DETAILS  (Info that comes from BASIC INFO) --}}
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
                            {!! Form::text('folder_number', $benefiter_folder_number, array('class' => 'custom-input-text text-align-right' , 'disabled')) !!}
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
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('lastname', Lang::get($p.'lastname')) !!}
                        {!! Form::text('lastname', $benefiter->lastname, array('class' => 'custom-input-text', 'disabled')) !!}
                    </div>
                    {{--NAME --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('name', Lang::get($p.'name')) !!}
                        {!! Form::text('name', $benefiter->name, array('class' => 'custom-input-text' , 'disabled')) !!}
                    </div>
                    {{-- GENDER --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('gender_id', Lang::get($p.'gender')) !!}
                        <div class="make-inline">
                            @if($benefiter->gender_id==1)
                            {!! Form::radio('gender_id', 1, true, array('class' => 'make-inline')) !!}
                            {!! Form::label('gender_id', Lang::get($p.'man'), array('class' => 'radio-value' , 'disabled')) !!}
                            {!! Form::radio('gender_id', 2, false, array('class' => 'make-inline')) !!}
                            {!! Form::label('gender_id', Lang::get($p.'woman'), array('class' => 'radio-value' , 'disabled')) !!}
                            @else
                            {!! Form::radio('gender_id', 1, false, array('class' => 'make-inline')) !!}
                            {!! Form::label('gender_id', Lang::get($p.'man'), array('class' => 'radio-value' , 'disabled')) !!}
                            {!! Form::radio('gender_id', 2, true, array('class' => 'make-inline')) !!}
                            {!! Form::label('gender_id', Lang::get($p.'woman'), array('class' => 'radio-value' , 'disabled')) !!}
                            @endif
                        </div>
                    </div>
                    {{-- DATE OF BIRTH --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('birth_date', Lang::get($p.'birth_date')) !!}
                        <div class="make-inline">
                            {!! Form::text('birth_date', $benefiter->birth_date, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="padding-left-right-15">
                    {{-- FATHERS NAME --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('fathers_name', Lang::get($p.'fathers_name')) !!}
                        {!! Form::text('fathers_name', $benefiter->fathers_name, array('class' => 'custom-input-text' , 'disabled')) !!}
                    </div>
                    {{-- MOTHERS NAME --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('mothers_name', Lang::get($p.'mothers_name')) !!}
                        {!! Form::text('mothers_name', $benefiter->mothers_name, array('class' => 'custom-input-text' , 'disabled')) !!}
                    </div>
                    {{-- NATIONALITY --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('nationality_country', Lang::get($p.'nationality')) !!}
                        {!! Form::text('nationality_country', $benefiter->nationality_country, array('class' => 'custom-input-text' , 'disabled')) !!}
                    </div>
                    {{-- ORIGIN COUNTRY --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('origin_country', Lang::get('basic_info_form.origin_country')) !!}
                        {!! Form::text('origin_country', null, array('class' => 'custom-input-text')) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="padding-left-right-15">
                    {{-- ARRIVAL DATE --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('arrival_date', Lang::get($p.'arrival_date')) !!}
                        {!! Form::text('arrival_date', $benefiter->arrival_date, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                    </div>
                    {{-- TELEPHONE --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('telephone', Lang::get('basic_info_form.telephone')) !!}
                        <?php
                            if($benefiter->telephone == 0){
                                $benefiter->telephone = "";
                            }
                        ?>
                        {!! Form::text('telephone', null, array('class' => 'custom-input-text')) !!}
                    </div>
                    {{-- ADDRESS --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('address', Lang::get('basic_info_form.address')) !!}
                        {!! Form::text('address', null, array('class' => 'custom-input-text address')) !!}
                    </div>

                    {{-- ETHNICITY --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('ethnic_group', Lang::get('basic_info_form.ethnic_group')) !!}
                        {!! Form::text('ethnic_group', null, array('class' => 'custom-input-text')) !!}
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
    {{-- MEDICAL FILE--}}
    <div class="row padding-top-20">
        <div class="col-md-12">
            <div class="row float-right">
                <div class="padding-left-right-15">
                    {{--<div class="form-group padding-left-right-15 float-left">--}}
                        {{--{!! Form::label('folder_number', Lang::get($p.'folder_number')) !!}--}}
                        {{--{!! Form::text('folder_number', $benefiter_folder_number, array('class' => 'custom-input-text text-align-right' , 'disabled')) !!}--}}
                    {{--</div>--}}
                    <div class="form-group padding-left-right-15 float-left">
                        {!! Form::label('medical_visit_id', Lang::get($p.'total_visits_number')) !!}
                        {!! Form::text('medical_visit_id', $medical_visits_number, array('class' => 'custom-input-text text-align-right' , 'disabled')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. MEDICAL HISTORY TABLE --}}
<div class="form-section">
    @if(($visit_submited_succesfully == 1))
        <div class="record-section-header padding-left-right-15 success-message">@lang($p.'success_visit')</div>
    @elseif($visit_submited_succesfully == 2)
        <div class="record-section-header padding-left-right-15 unsuccess-message">@lang($p.'unsuccess_visit')</div>
    @endif
    <div class="underline-header">
        <h1 class="record-section-header padding-left-right-15">2. @lang($p.'medical_history')</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="no-margin pos-relative" id="results-to-activate">
                <div class="display padding-20">
                    @if(count($benefiter_medical_history_list)>0)
                    <table id="benefiter_referrals_history" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Α/Α</th>
                            <th>@lang($p.'doctor')</th>
                            <th>@lang($p.'exam_location')</th>
                            <th>@lang($p.'exam_date')</th>
                            <th>@lang($p.'show_visit')</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Α/Α</th>
                            <th>@lang($p.'doctor')</th>
                            <th>@lang($p.'exam_location')</th>
                            <th>@lang($p.'exam_date')</th>
                            <th>@lang($p.'show_visit')</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @for($i=0 ; $i<count($benefiter_medical_history_list) ; $i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $benefiter_medical_history_list[$i]['doctor']['name'] }} {{ $benefiter_medical_history_list[$i]['doctor']['lastname'] }}</td>
                                <td>{{ $benefiter_medical_history_list[$i]['medicalLocation']['description'] }}</td>
                                @if($benefiter_medical_history_list[$i]['medical_visit_date'] == null)
                                <td>{{ $benefiter_medical_history_list[$i]['created_at'] }}</td>
                                @else
                                <td>{{ $benefiter_medical_history_list[$i]['medical_visit_date'] }}</td>
                                @endif
                                <th><button>Εμφάνιση</button></th>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                    @else
                    <h5 class="text-align-center">@lang($p.'no_medical_history')</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. NEW MEDICAL VISIT BUTTON (dropsdown the form) --}}
<div class="row padding-top-20">
    <div class="col-md-12">
        <button id="new-med-visit-button" class="lighter-green-background new-visit-button float-right padding-left-right-15 margin-30">@lang($p.'new_medical_visit')</button>
    </div>
</div>

<div id="new-medical-visit" class="basic-info-form">
    {!! Form::model($benefiter, array('url' => 'benefiter/'.$benefiter->id.'/medical-folder', 'files'=>true, 'id'=>'medical_visit_submit')) !!}
        {{-- get the benefiter id --}}
        {!! Form::hidden('benefiter_id', $benefiter->id) !!}
        {{-- get the doctor id --}}
        {!! Form::hidden('doctor_id', $doctor_id) !!}

        {{-- NEW VISIT NUMBER --}}
        <div class="row padding-top-20">
            <div class="col-md-12">
                <div class="row float-right">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15 float-left">
                            {!! Form::label('medical_visit_id', Lang::get($p.'new_visit_number')) !!}
                            {!! Form::text('medical_visit_id', $medical_visits_number+1, array('class' => 'custom-input-text text-align-right' , 'disabled')) !!}
                            {{--{!! Form::select('icd10_id', $icd10_description) !!}--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                {!! Form::text('doctor_name', Auth::user()->name.' '.Auth::user()->lastname, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                            </div>
                            {{-- ΗΜΕΡ. ΕΞΕΤΑΣΗΣ --}}
                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                {!! Form::label('examination_date', Lang::get($p.'exam_date')) !!}
                                {!! Form::text('examination_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                            {{-- ΤΟΠΟΘΕΣΙΑ ΕΞΕΤΑΣΗΣ --}}
                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                {!! Form::label('medical_location_id', Lang::get($p.'exam_location')) !!}
                                {!! Form::select('medical_location_id', $medical_locations_array) !!}
                            </div>
                            {{-- ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ --}}
                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                {!! Form::label('incident_type', Lang::get($p.'incident_type')) !!}
                                {!! Form::select('incident_type', ['Αντιμετώπιση στο ιατρείο',
                                                                    'Δόθηκαν συστάσεις',
                                                                    'Παραπομπή για διαγνωστικές',
                                                                    'Παραπομπή σε ειδικευμένο γιατρό']) !!}
                            </div>
                            {{-- ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ - ΠΕΡΙΣΤΑΤΙΚΟ --}}
                            {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">--}}
                                {{--{!! Form::label('incident_type_text', 'ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ') !!}--}}
                                {{--{!! Form::textarea('incident_type_text', null, ['size' => '30x3']) !!}--}}
                            {{--</div>--}}
                        </div>
                    </div>

                    {{-- main medical info --}}
                    <hr>
                    <div id="chronic-cond" class="row padding-bottom-30">
                        {{-- Fetch the posted input values if the post fails --}}
                        @if(!empty($chronic_conditions_sesssion))
                            @for($i=0; $i< count($chronic_conditions_sesssion) ; $i++)
                                <div  class="padding-left-right-15 chronicConditions condition-added-div">
                                    <div class="form-group float-left width-100-percent">
                                        {{-- ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ --}}
                                        <div class="make-inline col-md-4">
                                        {{-- if post fail then reprint what was entered in the fields --}}
                                            {!! Form::label('chronic_conditions', Lang::get($p.'chronic_conditions')) !!}
                                            {!! Form::text('chronic_conditions[]', "$chronic_conditions_sesssion[$i]", array('id'=>'chronCon', 'class' => 'custom-input-text display-inline')) !!}
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
                                    <div class="make-inline col-md-4">
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
                                {!! Form::text('height', null, array('class' => 'custom-input-text')) !!}
                            </div>
                            {{-- ΒΑΡΟΣ --}}
                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                {!! Form::label('weight', Lang::get($p.'weight')) !!}
                                {!! Form::text('weight', null, array('class' => 'custom-input-text')) !!}
                            </div>
                            {{-- ΘΕΡΜΟΚΡΑΣΙΑ --}}
                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                {!! Form::label('temperature', Lang::get($p.'temperature')) !!}
                                {!! Form::text('temperature', null, array('class' => 'custom-input-text')) !!}
                            </div>
                            {{-- ΑΡΤΗΡΙΑΚΗ ΠΙΕΣΗ --}}
                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                                {!! Form::label('blood_pressure', Lang::get($p.'blood_pressure')) !!}
                                {!! Form::text('blood_pressure_systolic', null, array('class' => 'custom-input-text display-inline width-30-percent','placeholder'=>Lang::get($p.'systolic'))) !!}
                                {!! Form::text('blood_pressure_diastolic', null, array('class' => 'custom-input-text display-inline width-30-percent','placeholder'=>Lang::get($p.'diastolic'))) !!}
                            </div>
                            {{-- ΠΕΡΙΜΕΤΡΟΣ ΚΡΑΝΙΟΥ (για νεογέννητα) --}}
                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                                {!! Form::label('skull_perimeter', Lang::get($p.'skull_perimeter')) !!}
                                {!! Form::text('skull_perimeter', null, array('class' => 'custom-input-text')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CLINICAL RESULTS --}}
        <div class="form-section no-bottom-border">
            <div class="underline-header">
                <h1 class="record-section-header padding-left-right-15">4. @lang($p.'clinical_results')</h1>
            </div>
            <div class="row">
                <div class="col-md-12 padding-left-right-30">
                    @if(!empty($examResultLoukup_session))
                        @for($i=0; $i<count($ExamResultsLookup) ; $i++)
                            @if($i%2 == 0)
                                <div class="row">
                            @endif
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-5" id="select-condition">
                                    {!! Form::label('examResultLoukup[]', $ExamResultsLookup[$i]['description'].':', array('class' => 'display-block width-270 max-width-none')) !!}
                                    <select id="clinical-select-{{$i}}" class="js-example-basic-multiple" multiple="multiple" name="examResultLoukup[{{$i}}][]" style="width:100%;">
                                        <option selected="selected" style="display: none"></option>
                                            @for($j=0 ; $j<count($examResultLoukup_session[$i]) ; $j++)
                                                @if(!empty($examResultLoukup_session[$i][$j]))
                                                    <option selected="selected" value="{{$examResultLoukup_session[$i][$j]}}" >{{$examResultLoukup_session[$i][$j]}}</option>
                                                @endif
                                            @endfor
                                    </select>
                                    {!! Form::textarea('examResultDescription[]', "$examResultDescription_session[$i]", ['size' => '35x5', 'class'=>'margin-top-20 width-100-percent']) !!}
                                </div>
                            @if($i%2 == 1)
                                </div>
                            @endif
                         @endfor
                    @else
                        @for($i=0; $i<count($ExamResultsLookup) ; $i++)
                            @if($i%2 == 0)
                                <div class="row">
                            @endif
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-5" id="select-condition">
                                    {!! Form::label('examResultLoukup[]', $ExamResultsLookup[$i]['description'].':', array('class' => 'display-block width-270 max-width-none')) !!}

                                    <select id="clinical-select-{{$i}}" class="js-example-basic-multiple" multiple="multiple" name="examResultLoukup[{{$i}}][]" style="width:100%;">
                                        <option selected="selected" style="display: none"></option>
                                    </select>
                                    {!! Form::textarea('examResultDescription[]', null, ['size' => '35x5', 'class'=>'margin-top-20 width-100-percent']) !!}
                                </div>
                            @if($i%2 == 1)
                                </div>
                            @endif
                         @endfor
                    @endif



                    {{--<div class="row">--}}
                        {{-- 1. RESPIRATORY SYSTEM --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('respiratory_system', 'RESPIRATORY SYSTEM:') !!}--}}
                            {{--{!! Form::textarea('respiratory_system', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                        {{-- 2. DIGESTIVE SYSTEM --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('digestive_system', 'DIGESTIVE SYSTEM:') !!}--}}
                            {{--{!! Form::textarea('digestive_system', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                            {{-- 3. SKIN & CUTANEOUS TISSUE --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('skin_tissue', 'SKIN & CUTANEOUS TISSUE:') !!}--}}
                            {{--{!! Form::textarea('skin_tissue', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{-- 4. CARDIOVASCULAR SYSTEM --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('cardiovascular_system', 'CARDIOVASCULAR SYSTEM:') !!}--}}
                            {{--{!! Form::textarea('cardiovascular_system', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                        {{-- 5. URINARY/REPRODUCTIVE SYSTEM --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('urinary_system', 'URINARY/REPRODUCTIVE SYSTEM:', array('class' => 'display-block width-270 max-width-none')) !!}--}}
                            {{--{!! Form::textarea('urinary_system', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                        {{-- 6. MUSCULOSKELETAL SYSTEM --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('musculoskeletal_system', 'MUSCULOSKELETAL SYSTEM:') !!}--}}
                            {{--{!! Form::textarea('musculoskeletal_system', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{-- 7. IMMUNIZATION (vaccine & date) --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('immunization_system', 'IMMUNIZATION (vaccine & date):') !!}--}}
                            {{--{!! Form::textarea('immunization_system', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                        {{-- 8. NERVOUS SYSTEM & SENSE ORGANS --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('nervous_system', 'NERVOUS SYSTEM & SENSE ORGANS:', array('class' => 'display-block width-270 max-width-none')) !!}--}}
                            {{--{!! Form::textarea('nervous_system', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                        {{-- 9. OTHER --}}
                        {{--<div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">--}}
                            {{--{!! Form::label('other', 'OTHER:') !!}--}}
                            {{--{!! Form::textarea('other', null, ['size' => '35x5']) !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>

        {{-- LABORATORY RESULTS --}}
        <div class="form-section no-bottom-border">
            <div class="underline-header">
                <h1 class="record-section-header padding-left-right-15">5. @lang($p.'lab_results')</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="lab-result" class="row padding-bottom-30">
                    @if(!empty($lab_results_session))
                        @for($i=0 ; $i<count($lab_results_session) ; $i++)
                            <div class="padding-left-right-15 lab-results lab-added-div">
                                <div class="form-group float-left width-100-percent">
                                    {{-- ΕΡΓΑΣΤΗΡΙΑΚΑ ΑΠΟΤΕΛΕΣΜΑΤΑ --}}
                                    <div class="make-inline col-md-10">
                                        {!! Form::label('lab_results', Lang::get($p.'lab_results_info')) !!}
                                        {!! Form::text('lab_results[]', "$lab_results_session[$i]", array('id'=>'labRes', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
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
                        <div  class="padding-left-right-15 medicationList">
                            <div class="form-group float-left width-100-percent">
                                {{-- ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ --}}
                                <div class="select-lists make-inline col-md-12">
                                    {!! Form::label('medicinal_name-[]', Lang::get($p.'medication_info')) !!}
                                    {!! Form::select('medication_name_from_lookup[]', [], null, array('id'=>'medicinal_name_1', 'class'=>'js-example-basic-multiple', 'style'=>'width:30%;')) !!}
                                    {{--<select id="medicinal_name-[]" class="js-example-basic-multiple " name="medication_name_from_lookup[]" style="width:30%;" >--}}
                                        {{--<option value="0">Other</option>--}}
                                    {{--</select>--}}
                                    {!! Form::text('medication_dosage[]', null, array('class' => 'custom-input-text display-inline margin-left-right-10px', 'placeholder' => Lang::get($p.'medicinal_dosage'))) !!}
                                    {!! Form::text('medication_duration[]', null, array('class' => 'custom-input-text display-inline margin-left-right-10px', 'placeholder' => Lang::get($p.'medicinal_duration'))) !!}

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
                                    {{-- Description --}}
                                    <div class="medication_other_name col-md-4 margin-left-11dot333per">
                                        {!! Form::textarea('medication_new_name[]', null, array('size' => '70x3', 'class' => 'border-1-grey custom-input-text display-inline width-100-percent margin-left-right-10px', 'placeholder' => Lang::get($p.'medicinal_name'))) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    @if(!empty($referrals_session))
                        @for($i=0; $i<count($referrals_session) ; $i++)
                            <div class="padding-left-right-15 referral ref-added-div">
                                <div class="form-group float-left width-100-percent">
                                    {{-- ΠΑΡΑΠΟΜΠΗ --}}
                                    <div class="make-inline col-md-10">
                                        {!! Form::label('referrals', Lang::get($p.'referrals_info')) !!}
                                        {!! Form::text('referrals[]', "$referrals_session[$i]", array('id'=>'refList', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
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
            <div id="upload_file">
            @if(!empty($upload_file_description_session) && !empty($upload_file_title_session))
                @for($i=0 ; $i<count($upload_file_description_session) ; $i++)
                    <div class="uploadFile file-added-div">
                        <div class="row">
                            <div class="padding-left-right-15">
                                {{-- ΑΝΕΒΑΣΜΑ ΑΡΧΕΙΟΥ --}}
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-8">
                                    {!! Form::label('upload_file_title', Lang::get($p.'file_details')) !!}
                                    {!! Form::text('upload_file_description[]', "$upload_file_description_session[$i]", array('id'=>'file', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                    {{-- add --}}
                                    <a class="color-green add-file" href="javascript:void(0)">
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
                                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-4">
                                    {!! Form::file('upload_file_title[]', "$upload_file_title_session[$i]", array('class' => 'custom-input-text')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            @else<div class="uploadFile">
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

        {{-- SUBMIT --}}
        <div class="form-section align-text-center">
            {!! Form::submit(Lang::get($p.'save_medical_visit'), array('class' => 'submit-button')) !!}
        </div>
    {!! Form::close() !!}
</div>
<script src="{{asset('js/records/custom_datepicker.js') }}"></script>
