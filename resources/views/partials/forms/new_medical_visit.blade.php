<div class="basic-info-form">

<?php
    $tab = "medical";
?>
@include('partials.select-panel')

{{-- MEDICAL FILE & VISIT NUMBER --}}
<div class="row padding-top-20">
    <div class="col-md-12">
        <div class="row float-right">
            <div class="padding-left-right-15">
                <div class="form-group padding-left-right-15 float-left">
                    {!! Form::label('folder_number', 'Αριθμός Φακέλου') !!}
                    {!! Form::text('folder_number', $benefiter_id, array('class' => 'custom-input-text text-align-right')) !!}
                </div>
                <div class="form-group padding-left-right-15 float-left">
                    {!! Form::label('medical_visit_id', 'Αριθμός επίσκεψης') !!}
                    {!! Form::text('medical_visit_id', 'α/α', array('class' => 'custom-input-text text-align-right')) !!}
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::open(array('action' => 'MainPanel\RecordsController@postMedicalFolder')) !!}
    {{-- get the benefiter id --}}
    {!! Form::hidden('benefiter_id', $benefiter_id) !!}
    {{-- get the doctor id --}}
    {!! Form::hidden('doctor_id', $doctor_id) !!}

    {{-- The medical_visit_id should probably be created when we get the form view --}}
    {{--{!! Form::hidden('medical_visit_id', $medical_visit_id) !!}--}}


    {{-- GENERAL DETAILS  (Info that comes from DB) --}}
    <div class="form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. Προσωπικά Στοιχεία</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- LASTNAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('lastname', 'ΕΠΩΝΥΜΟ') !!}
                            {!! Form::text('lastname', 'LASTNAME', array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                        {{--NAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('name', 'ΟΝΟΜΑ') !!}
                            {!! Form::text('name', 'NAME', array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                        {{-- GENDER --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('gender', 'ΦΥΛΟ') !!}
                            <div class="make-inline">
                                {!! Form::radio('gender', 1, true, array('class' => 'make-inline', 'disabled')) !!}
                                {!! Form::label('gender', 'Άνδρας', array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender', 2, false, array('class' => 'make-inline', 'disabled')) !!}
                                {!! Form::label('gender', 'Γυναίκα', array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                        {{-- DATE OF BIRTH --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('birth_date', 'ΗΜΕΡ. ΓΕΝΝΗΣΗΣ') !!}
                            <div class="make-inline">
                                {!! Form::text('birth_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- FATHERS NAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('fathers_name', 'ΠΑΤΡΩΝΥΜΟ') !!}
                            {!! Form::text('fathers_name', 'FATHERS NAME', array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                        {{-- MOTHERS NAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('mothers_name', 'ΜΗΤΡΩΝΥΜΟ') !!}
                            {!! Form::text('mothers_name', 'MOTHERS NAME', array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                        {{-- NATIONALITY --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('nationality_country', 'ΧΩΡΑ ΕΘΝΙΚΟΤΗΤΑΣ') !!}
                            {!! Form::text('nationality_country', 'NATIONALITY', array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- ARRIVAL DATE --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('arrival_date', 'ΗΜΕΡ. ΑΦΙΞΗΣ') !!}
                            {!! Form::text('arrival_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        {{-- ENTRY POINT --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('travel_route', 'Διαδρομή') !!}
                            {!! Form::text('travel_route', 'ΣΗΜΕΙΟ ΕΙΣΟΔΟΥ', array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                        {{-- DURATION OF TRAVEL --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('travel_duration', 'Διάρκεια') !!}
                            {!! Form::text('travel_duration', 'DURATION OF TRAVEL', array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BASIC MEDICAL DETAILS --}}
    <div class="form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. Βασικά Ιατρικά στοιχεία</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{-- general medical info --}}
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- ΟΝΟΜΑ ΙΑΤΡΟΥ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('doctor_name', 'ΟΝΟΜΑ ΙΑΤΡΟΥ') !!}
                            {!! Form::text('doctor_name', Auth::user()->name.' '.Auth::user()->lastname, array('class' => 'custom-input-text', 'disabled')) !!}
                        </div>
                        {{-- ΗΜΕΡ. ΕΞΕΤΑΣΗΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('examination_date', 'ΗΜΕΡ. ΕΞΕΤΑΣΗΣ') !!}
                            {!! Form::text('examination_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        {{-- ΤΟΠΟΘΕΣΙΑ ΕΞΕΤΑΣΗΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('medical_location_id', 'ΤΟΠΟΘΕΣΙΑ ΕΞΕΤΑΣΗΣ') !!}
                            {!! Form::select('medical_location_id', $medical_locations_array) !!}
                        </div>
                        {{-- ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('incident_type', 'ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ') !!}
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
                    <div  class="padding-left-right-15 chronicConditions">
                        <div class="form-group float-left width-100-percent">
                            {{-- ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ --}}
                            <div class="make-inline col-md-4">
                                {!! Form::label('chronic_conditions', 'ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ: ') !!}
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
                </div>
                <hr>
                {{-- physical examinations --}}
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- ΥΨΟΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('height', 'ΥΨΟΣ (cm)') !!}
                            {!! Form::text('height', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        {{-- ΒΑΡΟΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('weight', 'ΒΑΡΟΣ (kg)') !!}
                            {!! Form::text('weight', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        {{-- ΘΕΡΜΟΚΡΑΣΙΑ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('temperature', 'ΘΕΡΜΟΚΡΑΣΙΑ (Celsius)') !!}
                            {!! Form::text('temperature', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        {{-- ΑΡΤΗΡΙΑΚΗ ΠΙΕΣΗ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('blood_pressure', 'ΑΡΤΗΡΙΑΚΗ ΠΙΕΣΗ (mm Hg)') !!}
                            {!! Form::text('blood_pressure_systolic', null, array('class' => 'custom-input-text display-inline width-30-percent','placeholder'=>'ΣΥΣΤ.')) !!}
                            {!! Form::text('blood_pressure_diastolic', null, array('class' => 'custom-input-text display-inline width-30-percent','placeholder'=>'ΔΙΑΣΤ.')) !!}
                        </div>
                        {{-- ΠΕΡΙΜΕΤΡΟΣ ΚΡΑΝΙΟΥ (για νεογέννητα) --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                            {!! Form::label('skull_perimeter', 'ΠΕΡΙΜΕΤΡΟΣ ΚΡΑΝΙΟΥ για νεογέννητα (cm)') !!}
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
            <h1 class="record-section-header padding-left-right-15">3. Κλινικά αποτελέσματα</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                 @for($i=0; $i<count($ExamResultsLookup) ; $i++)
                    @if($i%3 == 0)
                        <div class="row">
                    @endif
                            <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                                {!! Form::label('examResultLoukup[]', $ExamResultsLookup[$i]['description'].':', array('class' => 'display-block width-270 max-width-none')) !!}
                                {!! Form::textarea('examResultLoukup[]', null, ['size' => '35x5']) !!}
                            </div>
                    @if($i%3 == 2)
                        </div>
                    @endif
                 @endfor


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
            <h1 class="record-section-header padding-left-right-15">4. Εργαστηριακά αποτελέσματα</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="lab-result" class="row padding-bottom-30">
                    <div  class="padding-left-right-15 lab-results">
                        <div class="form-group float-left width-100-percent">
                            {{-- ΕΡΓΑΣΤΗΡΙΑΚΑ ΑΠΟΤΕΛΕΣΜΑΤΑ --}}
                            <div class="make-inline col-md-10">
                                {!! Form::label('lab-results', 'ΕΡΓΑΣΤΗΡΙΑΚΑ ΑΠΟΤΕΛΕΣΜΑΤΑ: ') !!}
                                {!! Form::text('lab-results[]', null, array('id'=>'labRes', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
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
                </div>
            </div>
        </div>
    </div>

    {{-- MEDICATION DETAILS --}}
    <div class="form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">5. Φαρμακευτική αγωγή</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="medication" class="row padding-bottom-30">
                    <div  class="padding-left-right-15 medicationList">
                        <div class="form-group float-left width-100-percent">
                            {{-- ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ --}}
                            <div class="make-inline col-md-10">
                                {!! Form::label('medicationList', 'ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ: ') !!}
                                {!! Form::text('medicationList[]', null, array('id'=>'medList', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                {{-- add --}}
                                <a class="color-green add-med" href="javascript:void(0)">
                                    <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                </a>
                                {{-- remove --}}
                                <a class="color-red remove-med hide-element" href="javascript:void(0)">
                                    <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                </a>
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
            <h1 class="record-section-header padding-left-right-15">6. Παραπομπές</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="referrals" class="row padding-bottom-30">
                    <div  class="padding-left-right-15 referral">
                        <div class="form-group float-left width-100-percent">
                            {{-- ΠΑΡΑΠΟΜΠΗ --}}
                            <div class="make-inline col-md-10">
                                {!! Form::label('referrals', 'ΠΑΡΑΠΟΜΠΗ: ') !!}
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
                </div>
            </div>
        </div>
    </div>

    {{-- UPLOAD FILE --}}
    <div class="form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">7. Ανέβασμα αρχείου</h1>
        </div>
        <div id="upload_file">
            <div class="uploadFile">
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- ΑΝΕΒΑΣΜΑ ΑΡΧΕΙΟΥ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-8">
                            {!! Form::label('upload_file_title', 'ΠΕΡΙΓΡΑΦΗ ΑΡΧΕΙΟΥ: ') !!}
                            {!! Form::text('upload_file_title[]', null, array('id'=>'file', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
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
                            {!! Form::file('upload_file_path[]', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SUBMIT --}}
    <div class="form-section align-text-center">
        {!! Form::submit('Αποθήκευση Ιατρικής επίσκεψης', array('class' => 'submit-button')) !!}
    </div>
{!! Form::close() !!}
</div>
