    <?php
        $p = "partials/forms/new_medical_visit_form.";
    ?>
    {{-- 1. BASIC BENEFITER INFO --}}
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
                                $other = false;
                                if($benefiter->gender_id == 1){
                                    $male = true;
                                } elseif ($benefiter->gender_id == 2) {
                                    $female = true;
                                } else {
                                    $other = true;
                                }
                                ?>
                                <div class="make-inline">
                                    {!! Form::radio('gender_idm', 1, $male, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                    {!! Form::label('gender_idm', Lang::get('basic_info_form.male'), array('class' => 'radio-value')) !!}
                                    {!! Form::radio('gender_idf', 2, $female, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                    {!! Form::label('gender_idf', Lang::get('basic_info_form.female'), array('class' => 'radio-value')) !!}
                                    {!! Form::radio('gender_ido', 3, $other, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                    {!! Form::label('gender_ido', Lang::get('basic_info_form.other'), array('class' => 'radio-value')) !!}
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. BASIC MEDICAL INFO -----}}
    <div class="form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. @lang($p.'medical_info')</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{-- general medical info --}}
                <div class="row">
                    <div class="padding-left-right-15">

                        {{-- ΟΝΟΜΑ ΙΑΤΡΟΥ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('doctor_name', Lang::get($p.'doctor_name')) !!}
                            <div class="custom-input-text">
                                {{$med_visit_doctor}}
                            </div>
                        </div>
                        {{-- ΗΜΕΡ. ΕΞΕΤΑΣΗΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('examination_date', Lang::get($p.'exam_date')) !!}
                            <div class="custom-input-text">
                                {{$med_visit_date}}
                            </div>
                        </div>
                        {{-- ΤΟΠΟΘΕΣΙΑ ΕΞΕΤΑΣΗΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-3">
                            {!! Form::label('medical_location_id', Lang::get($p.'exam_location')) !!}
                            <div class="custom-input-text">
                            {{ $med_visit_location }}
                            </div>
                        </div>
                        {{-- ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ --}}
                        <div class="form-group make-inline padding-left-right-15 float-left col-xs-4">
                            {!! Form::label('incident_type', Lang::get($p.'incident_type')) !!}
                            <div class="custom-input-text">
                                {{$med_visit_incident_type}}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- main medical info --}}
                <hr>
                @if(!empty($med_visit_chronic_conditions))
                    @foreach($med_visit_chronic_conditions as $cron_con)
                        @if(!empty($cron_con))
                            <div id="chronic-cond-visit" class="row padding-bottom-30">
                                <div  class="padding-left-right-15">
                                    <div class="form-group float-left width-100-percent">
                                        {{-- ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ --}}
                                        <div class="make-inline col-xs-3">
                                        {{-- if post fail then reprint what was entered in the fields --}}
                                            {!! Form::label('chronic_conditions', Lang::get($p.'chronic_conditions')) !!}
                                            <div class="custom-input-text">
                                                {{$cron_con['description']}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
                <hr>
                {{-- physical examinations --}}
                <div class="row">
                    <div class="padding-left-right-15">
                        {{-- ΥΨΟΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-1">
                            {!! Form::label('height', Lang::get($p.'height')) !!}
                            <div class="custom-input-text">
                                {{ $med_visit_height }}
                            </div>
                        </div>
                        {{-- ΒΑΡΟΣ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-1">
                            {!! Form::label('weight', Lang::get($p.'weight')) !!}
                            <div class="custom-input-text">
                               {{ $med_visit_weight }}
                            </div>
                        </div>
                        {{-- ΘΕΡΜΟΚΡΑΣΙΑ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('temperature', Lang::get($p.'temperature')) !!}
                            <div class="custom-input-text">
                                {{ $med_visit_temperature }}
                            </div>
                        </div>
                        {{-- ΑΡΤΗΡΙΑΚΗ ΠΙΕΣΗ --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-3">
                            {!! Form::label('blood_pressure', Lang::get($p.'blood_pressure'), array('class' => 'margin-0')) !!}
                            <div class="custom-input-text display-inline width-30-percent margin-top-minus-3">
                                {!! Form::label('blood_pressure', Lang::get($p.'diastolic')) !!}
                                {{ $med_visit_blood_pressure_diastolic }}
                            </div>

                            <div class="custom-input-text display-inline width-30-percent margin-top-minus-3">
                                {!! Form::label('blood_pressure', Lang::get($p.'systolic')) !!}
                                {{ $med_visit_blood_pressure_systolic }}
                            </div>
                        </div>
                        {{-- ΠΕΡΙΜΕΤΡΟΣ ΚΡΑΝΙΟΥ (για νεογέννητα) --}}
                        <div class="form-group make-inline padding-left-right-15 float-left col-xs-3">
                            {!! Form::label('skull_perimeter', Lang::get($p.'skull_perimeter')) !!}
                            <div class="custom-input-text">
                                {{ $med_visit_skull_perimeter }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. CLINICAL RESULTS INFO --}}
    <div class="form-section no-bottom-border padding-bottom-30">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. @lang($p.'clinical_results')</h1>
        </div>
        {{-- titles --}}
        <div class="row margin-15-30 border-bottom-light-thick">
            <div class=" col-xs-2">
                <label class="font-weight-700">@lang($p.'condition-name')</label>
            </div>
            <div class=" col-xs-6">
                <label class="font-weight-700">@lang($p.'icd10')</label>
            </div>
            <div class=" col-xs-4">
                <label class="font-weight-700">@lang($p.'description')</label>
            </div>
        </div>
        <?php
            $examResultsLookupLength = count($ExamResultsLookup);
            $i = 0;
        ?>
        @foreach($ExamResultsLookup as $med_exam)
            @if($i == $examResultsLookupLength - 1)
            <div class="row margin-15-30 border-bottom-light margin-bottom-0">
            @else
            <div class="row margin-15-30 border-bottom-light">
            @endif
                <div class="form-group padding-left-right-15 col-xs-2">
                    <label> {{ $med_exam['description'] }} </label>
                </div>
                <?php $duplicity_counter = 0; ?>
                @if(!empty($med_visit_exam_results))
                    {{-- one foreach to fetch icd10 --}}
                <div class="form-group padding-left-right-15 col-xs-6">
                    <div class="row">
                        <div class=" form-group padding-left-right-15 col-md-12">
                            <ul>
                                @foreach($med_visit_exam_results as $med_exam_result)
                                    @if($med_exam_result['results_lookup_id'] == $med_exam['id'])
                                        @if(!empty($med_exam_result['icd10_id']))
                                            <li>
                                                {{ $med_exam_result['icd10']['code'] }}: {{ $med_exam_result['icd10']['description'] }}
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                        {{-- one more foreach to fetch descriptions, but only once --}}
                    @foreach($med_visit_exam_results as $med_exam_result)
                        @if($med_exam_result['results_lookup_id'] == $med_exam['id'])
                            @if($duplicity_counter == 0)
                                <div class=" form-group padding-left-right-15 col-xs-4">
                                    {{ $med_exam_result['description'] }}
                                </div>
                                <?php $duplicity_counter++; ?>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>

    {{-- 4. LAB RESULTS INFO -------}}
    <div class="form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">4. @lang($p.'lab_results')</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="lab-result-visit" class="row padding-bottom-30">
                    <div class="padding-left-right-15 ">
                        <div class="form-group float-left width-100-percent">
                            {{-- ΕΡΓΑΣΤΗΡΙΑΚΑ ΑΠΟΤΕΛΕΣΜΑΤΑ --}}
                            @if(!empty($med_visit_lab_results))
                                @foreach($med_visit_lab_results as $lab_result)
                                    <div class="make-inline col-md-10">
                                        {!! Form::label('lab_results', Lang::get($p.'lab_results_info')) !!}
                                        <div class="custom-input-text display-inline width-50-percent">
                                            {{ $lab_result['laboratory_results'] }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. MEDICINAL LIST INFO ----}}
    <div class="form-section no-bottom-border padding-bottom-30">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">5. @lang($p.'medication')</h1>
        </div>
        @if(!empty($med_visit_medication))
            @foreach($med_visit_medication as $med_medication)
                <div class="row padding-bottom-30">
                    <div class="col-md-12">
                        {{-- medicine name --}}
                        <div class="col-xs-5">
                            {!! Form::label('medication_name', Lang::get($p.'medication_info')) !!}
                            <div class="custom-input-text display-inline">
                                {{ $med_medication['medical_medication_lookup']['description'] }}
                            </div>

                        </div>
                        {{-- medicine dosage --}}
                        <div class="col-xs-2">
                            {!! Form::label('medicinal_dosage', Lang::get($p.'medicinal_dosage')) !!}
                            <div class="custom-input-text display-inline">
                                {{ $med_medication['dosage'] }}
                            </div>

                        </div>
                        {{-- medicine duration --}}
                        <div class="col-xs-2">
                            {!! Form::label('medicinal_duration', Lang::get($p.'medicinal_duration')) !!}
                            <div class="custom-input-text display-inline">
                                {{ $med_medication['duration'] }}
                            </div>

                        </div>
                        {{-- supplied from PRAKSIS --}}
                        <div class="col-xs-2">
                            {!! Form::label('supply', Lang::get($p.'supply_from_praksis')) !!}
                            @if($med_medication['supply_from_praksis'] == 1)
                                {!! Form::checkbox('supply', 1, true, array('class'=>'supply_from_praksis make-inline', 'disabled' => 'disabled')) !!}
                            @else
                                {!! Form::checkbox('supply', 0, false, array('class'=>'supply_from_praksis make-inline', 'disabled' => 'disabled')) !!}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- 6. REFERALS INFO ----------}}
    <div class="form-section no-bottom-border padding-bottom-30">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">6. @lang($p.'referrals')</h1>
        </div>
        @if(!empty($med_visit_referrals))
            @foreach($med_visit_referrals as $med_referral)
                <div class="row padding-bottom-30">
                    {{-- referral name --}}
                    <div class="col-md-6">
                        {!! Form::label('medication_name', Lang::get($p.'referrals_info')) !!}
                        <div class="custom-input-text display-inline">
                            {{ $med_referral['referrals'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- 7. UPLOADED FILES LIST ----}}
    <div class="form-section">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">7. @lang($p.'upload')</h1>
        </div>
        @if(!empty($med_visit_uploads))
            @foreach($med_visit_uploads as $med_upload)
                <div class="row padding-left-right-15">
                    {{-- uploaded file title --}}
                    <div class="make-inline padding-left-right-15 float-left  saved-file">
                        {!! Form::label('medication_name', Lang::get($p.'upload_title')) !!}
                        <div class="custom-input-text display-inline">
                            <a href="{{ url($med_upload['path'] . $med_upload['title']) }}" target="_blank">{{ $med_upload['title'] }}</a>
                        </div>
                    </div>
                    {{-- uploaded file description --}}
                    <div class="make-inline padding-left-right-15 margin-right-30 float-left max-width-60per">
                        {!! Form::label('medication_name', Lang::get($p.'upload_description')) !!}
                        <div class="custom-input-text display-inline upload-description">
                            {{ $med_upload['description'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
