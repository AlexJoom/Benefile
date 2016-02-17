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
                    {!! Form::label('travel_route', 'Αριθμός Φακέλου') !!}
                    {!! Form::text('travel_route', 'α/α', array('class' => 'custom-input-text text-align-right')) !!}
                </div>
                <div class="form-group padding-left-right-15 float-left">
                    {!! Form::label('travel_duration', 'Αριθμός επίσκεψης') !!}
                    {!! Form::text('travel_duration', 'α/α', array('class' => 'custom-input-text text-align-right')) !!}
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::open(array('url' => 'new-benefiter/medical-folder')) !!}
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
                            {!! Form::text('doctor_name', 'Dr. House', array('class' => 'custom-input-text')) !!}
                        </div>
                        {{-- ΗΜΕΡ. ΕΞΕΤΑΣΗΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('examination_date', 'ΗΜΕΡ. ΕΞΕΤΑΣΗΣ') !!}
                            {!! Form::text('examination_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        {{-- ΤΟΠΟΘΕΣΙΑ ΕΞΕΤΑΣΗΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('examination_location', 'ΤΟΠΟΘΕΣΙΑ ΕΞΕΤΑΣΗΣ') !!}
                            {!! Form::select('examination_location', ['Κέντρο κράτησης Κορίνθου',
                                                                        'Πολυιατρείο Αθήνας',
                                                                        'Πολυιατρείο Θεσσαλονίκης',
                                                                        'Κέντρο Ημέρας Αθήνας',
                                                                        'Κέντρο Ημέρας']) !!}
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
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('incident_type_text', 'ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ') !!}
                            {!! Form::textarea('incident_type_text', null, ['size' => '30x3']) !!}
                        </div>
                    </div>
                </div>

                {{-- main medical info --}}
                <div id="chronic-cond" class="row padding-bottom-30">
                    <div  class="padding-left-right-15 chronicConditions">
                        <div class="form-group float-left width-100-percent">
                            {{-- ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ --}}
                            <div class="make-inline col-md-4">
                                {!! Form::label('chronic_conditions', 'ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ: ') !!}
                                {!! Form::text('chronic_conditions', null, array('id'=>'chronCon', 'class' => 'custom-input-text display-inline')) !!}
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
                            {!! Form::label('skull-perimeter', 'ΠΕΡΙΜΕΤΡΟΣ ΚΡΑΝΙΟΥ (για νεογέννητα)') !!}
                            {!! Form::text('skull-perimeter', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CLINICAL RESULTS --}}
    <div class="legal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. Κλινικά αποτελέσματα</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    {{-- 1. RESPIRATORY SYSTEM --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('respiratory_system', 'RESPIRATORY SYSTEM:') !!}
                        {!! Form::textarea('respiratory_system', null, ['size' => '30x2']) !!}
                    </div>
                    {{-- 2. DIGESTIVE SYSTEM --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('digestive_system', 'DIGESTIVE SYSTEM:') !!}
                        {!! Form::textarea('digestive_system', null, ['size' => '30x2']) !!}
                    </div>
                        {{-- 3. SKIN & CUTANEOUS TISSUE --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('skin_tissue', 'SKIN & CUTANEOUS TISSUE:') !!}
                        {!! Form::textarea('skin_tissue', null, ['size' => '30x2']) !!}
                    </div>
                    {{-- 4. CARDIOVASCULAR SYSTEM --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('cardiovascular_system', 'CARDIOVASCULAR SYSTEM:') !!}
                        {!! Form::textarea('cardiovascular_system', null, ['size' => '30x2']) !!}
                    </div>
                    {{-- 5. URINARY/REPRODUCTIVE SYSTEM --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('urinary_system', 'URINARY/REPRODUCTIVE SYSTEM:', array('class' => 'display-block width-260 max-width-none')) !!}
                        {!! Form::textarea('urinary_system', null, ['size' => '30x2']) !!}
                    </div>
                </div>
                <div class="row">
                    {{-- 6. MUSCULOSKELETAL SYSTEM --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('musculoskeletal_system', 'MUSCULOSKELETAL SYSTEM:') !!}
                        {!! Form::textarea('musculoskeletal_system', null, ['size' => '30x2']) !!}
                    </div>
                    {{-- 7. IMMUNIZATION (vaccine & date) --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('immunization_system', 'IMMUNIZATION (vaccine & date):') !!}
                        {!! Form::textarea('immunization_system', null, ['size' => '30x2']) !!}
                    </div>
                    {{-- 8. NERVOUS SYSTEM & SENSE ORGANS --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('nervous_system', 'NERVOUS SYSTEM & SENSE ORGANS:', array('class' => 'display-block width-260 max-width-none')) !!}
                        {!! Form::textarea('nervous_system', null, ['size' => '30x2']) !!}
                    </div>
                    {{-- 9. OTHER --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('other', 'OTHER:') !!}
                        {!! Form::textarea('other', null, ['size' => '30x2']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LABORATORY RESULTS --}}
    <div class="education-info form-section no-bottom-border">
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
                                {!! Form::text('lab-results', null, array('id'=>'labRes', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
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
    <div class="work-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">6. Φαρμακευτική αγωγή</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="medication" class="row padding-bottom-30">
                    <div  class="padding-left-right-15 medicationList">
                        <div class="form-group float-left width-100-percent">
                            {{-- ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ --}}
                            <div class="make-inline col-md-10">
                                {!! Form::label('medicationList', 'ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ: ') !!}
                                {!! Form::text('medicationList', null, array('id'=>'medList', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
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

    {{-- UPLOAD FILE --}}
    <div class="country-abandon-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">7. Ανέβασμα αρχείου</h1>
        </div>
        <div class="row">
            <div class="padding-left-right-15">
                {{-- ΑΝΕΒΑΣΜΑ ΑΡΧΕΙΟΥ --}}
                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-8">
                    {!! Form::label('upload_file_title', 'ΠΕΡΙΓΡΑΦΗ ΑΡΧΕΙΟΥ: ') !!}
                    {!! Form::text('upload_file_title', null, array('class' => 'custom-input-text display-inline width-50-percent')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="padding-left-right-15">
                <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-4">
                    {!! Form::file('upload_file', null, array('class' => 'custom-input-text')) !!}
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
