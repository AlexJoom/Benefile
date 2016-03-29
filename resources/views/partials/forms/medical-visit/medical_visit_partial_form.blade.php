{{-- NEW VISIT NUMBER --}}
<div class="row padding-top-20 width-100-percent">
    <div class="col-md-12">
        <div class="row float-right">
            <div class="padding-left-right-15">
                <div class="form-group padding-left-right-15 float-left">
                    {!! Form::label('medical_visit_id', Lang::get($p.'new_visit_number')) !!}
                    {!! Form::text('medical_visit_id', $medical_visits_number+1, array('class' => 'custom-input-text text-align-right' , 'disabled')) !!}
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
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                        {!! Form::label('medical_location_id', Lang::get($p.'exam_location')) !!}
                        {!! Form::select('medical_location_id', $medical_locations_array) !!}
                    </div>
                    {{-- ΤΥΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                        {!! Form::label('medical_incident_id', Lang::get($p.'incident_type')) !!}
                        {!! Form::select('medical_incident_id', $medical_incident_type_array) !!}
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
                        <div  class="padding-left-right-15 @if($i==0) chronicConditions @else condition-added-div @endif">
                            <div class="form-group float-left width-100-percent">
                                {{-- ΧΡΟΝΙΕΣ ΠΑΘΗΣΕΙΣ --}}
                                <div class="make-inline col-md-6">
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
                        {!! Form::text('height', null, array('class' => 'custom-input-text')) !!}
                    </div>
                    {{-- ΒΑΡΟΣ --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('weight', Lang::get($p.'weight')) !!}
                        {!! Form::text('weight', null, array('class' => 'custom-input-text')) !!}
                    </div>
                    {{-- ΘΕΡΜΟΚΡΑΣΙΑ --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                        {!! Form::label('temperature', Lang::get($p.'temperature')) !!}
                        {!! Form::text('temperature', null, array('class' => 'custom-input-text')) !!}
                    </div>
                    {{-- ΑΡΤΗΡΙΑΚΗ ΠΙΕΣΗ --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                        {!! Form::label('blood_pressure', Lang::get($p.'blood_pressure')) !!}
                        {!! Form::text('blood_pressure_systolic', null, array('class' => 'custom-input-text display-inline width-30-percent','placeholder'=>Lang::get($p.'systolic'))) !!}
                        {!! Form::text('blood_pressure_diastolic', null, array('class' => 'custom-input-text display-inline width-30-percent','placeholder'=>Lang::get($p.'diastolic'))) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="padding-left-right-15">
                    {{-- ΠΕΡΙΜΕΤΡΟΣ ΚΡΑΝΙΟΥ (για νεογέννητα) --}}
                    <div class="form-group make-inline padding-left-right-15 float-left col-md-4">
                        {!! Form::label('skull_perimeter', Lang::get($p.'skull_perimeter')) !!}
                        {!! Form::text('skull_perimeter', null, array('class' => 'custom-input-text')) !!}
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
    {{--<div class="col-md-12 padding-left-right-30">--}}
        @if(!empty($examResultLoukup_session))
            @for($i=0; $i<count($ExamResultsLookup) ; $i++)
                {{--@if($i%2 == 0)--}}
                    <div class="row padding-left-right-30 padding-top-bottom-15">
                {{--@endif--}}
                        <div class="form-group padding-left-right-15 margin-right-30 float-left col-md-8 clinical-results" id="select-condition">
                            {!! Form::label('examResultLoukup[{{$i}}][]', $ExamResultsLookup[$i]['description'].':', array('class' => 'display-block width-270 max-width-none')) !!}
                            <select id="clinical-select-{{$i}}" class="js-example-basic-multiple" multiple="multiple" name="examResultLoukup[{{$i}}][]" style="width:100%;">
                                <option selected="selected" style="display: none"></option>
                                    @for($j=0 ; $j<count($examResultLoukup_session[$i]) ; $j++)
                                        @if(!empty($examResultLoukup_session[$i][$j]))
                                            <option selected="selected" value="{{$examResultLoukup_session[$i][$j]}}" >{{$examResultLoukup_session_description[$i][$j]}}</option>
                                        @endif
                                    @endfor
                            </select>
                            {!! Form::textarea('examResultDescription[]', "$examResultDescription_session[$i]", ['size' => '35x5', 'class'=>'custom-input-textarea margin-top-20 width-100-percent max-width-100per', 'style' => 'display: none;']) !!}
                        </div>
{{--                        @if($i%2 == 1)--}}
                    </div>
                {{--@endif--}}
             @endfor
        @else
            @for($i=0; $i<count($ExamResultsLookup) ; $i++)
                {{--@if($i%2 == 0)--}}
                    <div class="row padding-left-right-30 padding-top-bottom-15">
                {{--@endif--}}
                    <div id="examajax" data-url="{{ url("/") }}" class=" form-group padding-left-right-15 margin-right-30 float-left col-md-8 clinical-results" id="select-condition">
                        {!! Form::label('examResultLoukup[]', $ExamResultsLookup[$i]['description'].':', array('class' => 'display-block width-270 max-width-none')) !!}
                        <select id="clinical-select-{{$i}}" class="js-example-basic-multiple" multiple="multiple" name="examResultLoukup[{{$i}}][]" style="width:100%;">
                            <option selected="selected" style="display: none"></option>
                        </select>
                        {!! Form::textarea('examResultDescription[]', null, ['size' => '35x5', 'class'=>'custom-input-textarea margin-top-20 width-100-percent max-width-100per', 'style' => 'display: none;']) !!}
                    </div>
{{--                        @if($i%2 == 1)--}}
                    </div>
                {{--@endif--}}
             @endfor
        @endif
    {{--</div>--}}
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
                        <div class="padding-left-right-15 @if($i==0) lab-results @else lab-added-div @endif">
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
                @if(!empty($medication_dosage_session) && !empty($medication_duration_session))

                    @for($i=0 ; $i<count($supply_from_praksis_hidden_session) ; $i++)
                        <div  class="padding-left-right-15 @if($i==0) medicationList @endif @if($i!=0) med-added-div @endif">
                            <div class="row">
                                <div class="form-group float-left col-md-12">
                                    {{--ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ--}}
                                    <div class="select-lists make-inline col-md-6">
                                        {!! Form::label('medication_name_from_lookup[]', Lang::get($p.'medication_info')) !!}
                                        {{--{!! Form::select('medication_name_from_lookup[]', [], '', array('id'=>'medicinal_name_1', 'class'=>'js-example-basic-multiple', 'style'=>'width:30%;')) !!}--}}
                                        <select id="medicinal_name_{{$i+1}}" class="js-example-basic-multiple " name="medication_name_from_lookup[]">
                                            @if(!empty($medication_name_from_lookup_session[$i]) && $medication_name_from_lookup_session[$i] != -1 ))
                                                <option selected="selected" value="{{$medication_name_from_lookup_session[$i]}}" >{{$medication_name_from_lookup_session_description[$i]}}</option>
                                            @endif
                                        </select>
                                    </div>
                                    {{--Description--}}
                                    @if(!empty($medication_new_name_session[$i]))
                                        <div class="medication_other_name col-md-6" style="display: block !important;">
                                            {{--{!! Form::textarea('medication_new_name[]', "$medication_new_name_session[$i]", array('size' => '70x3', 'class' => 'border-1-grey custom-input-text display-inline width-100-percent margin-left-right-10px', 'placeholder' => Lang::get($p.'medicinal_name'))) !!}--}}
                                            {{--{!! Form::label('medication_new_name[]') !!}--}}
                                            <input type="text" name="medication_new_name[]" placeholder="@lang($p.'medicinal_name')" class="custom-input-text display-inline width-100-percent" value="{{$medication_new_name_session[$i]}}"/>
                                        </div>
                                    @else
                                        <div class="medication_other_name col-md-6" style="display: none;">
                                            {{--{!! Form::textarea('medication_new_name[]', "$medication_new_name_session[$i]", array('size' => '70x3', 'class' => 'border-1-grey custom-input-text display-inline width-100-percent margin-left-right-10px', 'placeholder' => Lang::get($p.'medicinal_name'))) !!}--}}
                                            {{--{!! Form::label('medication_new_name[]') !!}--}}
                                            <input type="text" name="medication_new_name[]" placeholder="@lang($p.'medicinal_name')" class="custom-input-text display-inline width-100-percent" value="{{$medication_new_name_session[$i]}}"/>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div  class="padding-left-right-15">
                                    <div class="form-group float-left col-md-6 padding-left-50px">
                                        {!! Form::text('medication_dosage[]', "$medication_dosage_session[$i]", array('class' => 'custom-input-text display-inline', 'placeholder' => Lang::get($p.'medicinal_dosage'))) !!}
                                        {!! Form::text('medication_duration[]', "$medication_duration_session[$i]", array('class' => 'custom-input-text display-inline', 'placeholder' => Lang::get($p.'medicinal_duration'))) !!}
                                    </div>
                                    <div class="form-group float-left col-md-3">
                                        {!! Form::label('supply_from_praksis[]', Lang::get($p.'supply_from_praksis'), array('class' => 'radio-value margin-right-10px')) !!}
                                        {!! Form::hidden('supply_from_praksis_hidden[]', $supply_from_praksis_hidden_session[$i], array('class'=>'supply_from_praksis_hidden'))!!}
                                        @if($supply_from_praksis_hidden_session[$i] != 0)
                                        {{--{!! Form::checkbox('supply_from_praksis[]', "$supply_from_praksis_hidden_session[$i]", true, array('class'=>'supply_from_praksis make-inline')) !!}--}}
                                        <input name="supply_from_praksis[]" class="supply_from_praksis make-inline" type="checkbox" value="$supply_from_praksis_hidden_session[$i]" checked>
                                        @else
                                        {{--{!! Form::checkbox('supply_from_praksis[]', "$supply_from_praksis_hidden_session[$i]", false, array('class'=>'supply_from_praksis make-inline')) !!}--}}
                                        <input name="supply_from_praksis[]" class="supply_from_praksis make-inline" type="checkbox" value="$supply_from_praksis_hidden_session[$i]">
                                        @endif
                                        {{--add--}}
                                        @if($i<1)
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
                    <div class="padding-left-right-15 medicationList">
                        <div class="row">
                            <div class="form-group col-md-12 float-left">
                                {{-- ΦΑΡΜΑΚΕΥΤΙΚΗ ΑΓΩΓΗ --}}
                                <div id="medicationajax" data-url="{{ url("/") }}" class="select-lists make-inline col-md-6">
                                    {!! Form::label('medication_name_from_lookup[]', Lang::get($p.'medication_info')) !!}
                                    {{--{!! Form::select('medication_name_from_lookup[]', [], '', array('id'=>'medicinal_name_1', 'class'=>'js-example-basic-multiple', 'style'=>'width:30%;')) !!}--}}
                                    <select id="medicinal_name_1" class="js-example-basic-multiple" name="medication_name_from_lookup[]">
                                        {{--<option value="-1" selected="selected">Επιλέξτε αγωγή</option>--}}
                                    </select>
                                </div>
                                {{-- Description --}}
                                <div class="medication_other_name col-md-6">
                                    {!! Form::text('medication_new_name[]', null, array('class' => 'custom-input-text display-inline width-100-percent ', 'placeholder' => Lang::get($p.'medicinal_name'))) !!}
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
                @if(!empty($referrals_session))
                    @for($i=0; $i<count($referrals_session) ; $i++)
                        <div class="padding-left-right-15 @if($i==0) referral @else ref-added-div @endif">
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
    <div class="row">
        <div class="col-md-12">
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
