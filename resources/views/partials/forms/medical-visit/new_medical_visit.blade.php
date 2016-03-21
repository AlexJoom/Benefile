<?php
    $p = "partials/forms/new_medical_visit_form.";
    // format correctly the dates!
    $datesHelper = new \app\Services\DatesHelper();
    if (isset($benefiter) and $benefiter != null){
        if ($benefiter->birth_date != null) {
            $benefiter->birth_date = $datesHelper->getFinelyFormattedStringDateFromDBDate($benefiter->birth_date);
        }
        if ($benefiter->arrival_date != null) {
            $benefiter->arrival_date = $datesHelper->getFinelyFormattedStringDateFromDBDate($benefiter->arrival_date);
        }
    }
?>


{{--------------- 1. GENERAL DETAILS  (Info that comes from BASIC INFO) ---------------}}
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
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
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
                        {!! Form::text('origin_country', $benefiter->origin_country, array('class' => 'custom-input-text', 'disabled')) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="padding-left-right-15">
                    {{-- ARRIVAL DATE --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('arrival_date', Lang::get($p.'arrival_date')) !!}
                        {!! Form::text('arrival_date', $benefiter->arrival_date, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}
                    </div>
                    {{-- TELEPHONE --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('telephone', Lang::get('basic_info_form.telephone')) !!}
                        <?php
                            if($benefiter->telephone == 0){
                                $benefiter->telephone = "";
                            }
                        ?>
                        {!! Form::text('telephone', $benefiter->telephone, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                    </div>
                    {{-- ADDRESS --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                        {!! Form::label('address', Lang::get('basic_info_form.address')) !!}
                        {!! Form::text('address', $benefiter->address, array('class' => 'custom-input-text address', 'disabled' => 'disabled')) !!}
                    </div>

                    {{-- ETHNICITY --}}
                    <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
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

{{--------------- 2. MEDICAL HISTORY TABLE --------------------------------------------}}
<div class="form-section">
    @if(($visit_submited_succesfully == 1))
        <div class="record-section-header padding-left-right-15 success-message">
            @lang($p.'success_visit')
        </div>
    @elseif($visit_submited_succesfully == 2)
        <div class="record-section-header padding-left-right-15 unsuccess-message">
            @lang($p.'unsuccess_visit')
        </div>
    @endif
    <div class="underline-header">
        <h1 class="record-section-header padding-left-right-15">2. @lang($p.'medical_history')</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="no-margin pos-relative" id="results-to-activate">
                <div class="display padding-20">
                    @if(count($benefiter_medical_visits_list)>0)
                    <table id="benefiter_referrals_history" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Α/Α</th>
                                <th>@lang($p.'doctor')</th>
                                <th>@lang($p.'doctor_speciality')</th>
                                <th>@lang($p.'exam_location')</th>
                                <th>@lang($p.'incident_type')</th>
                                <th>@lang($p.'exam_date')</th>
                                <th>@lang($p.'show_visit')</th>
                                <th>@lang($p.'edit_visit_info')</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Α/Α</th>
                                <th>@lang($p.'doctor')</th>
                                <th>@lang($p.'doctor_speciality')</th>
                                <th>@lang($p.'exam_location')</th>
                                <th>@lang($p.'incident_type')</th>
                                <th>@lang($p.'exam_date')</th>
                                <th>@lang($p.'show_visit')</th>
                                <th>@lang($p.'edit_visit_info')</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @for($i=0 ; $i<count($benefiter_medical_visits_list) ; $i++)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $benefiter_medical_visits_list[$i]['doctor']['name'] }} {{ $benefiter_medical_visits_list[$i]['doctor']['lastname'] }}</td>
                                    @if($benefiter_medical_visits_list[$i]['doctor']['user_subrole_id'] == null)
                                    <td>@lang($p.'admin')</td>
                                    @else
                                    <td>{{ $benefiter_medical_visits_list[$i]['doctor']['subrole']['subrole'] }}</td>
                                    @endif
                                    <td>{{ $benefiter_medical_visits_list[$i]['medicalLocation']['description'] }}</td>
                                    <td>{{ $benefiter_medical_visits_list[$i]['medicalIncidentType']['description'] }}</td>
                                    @if($benefiter_medical_visits_list[$i]['medical_visit_date'] == null)
                                    <td>{{ $datesHelper->getFinelyFormattedStringDateFromDBDate($benefiter_medical_visits_list[$i]['created_at']) }}</td>
                                    @else
                                    <td>{{ $datesHelper->getFinelyFormattedStringDateFromDBDate($benefiter_medical_visits_list[$i]['medical_visit_date']) }}</td>
                                    @endif
                                    <td>
                                    {{-- Only admin and doctor rolesshould be able to view and edit medical visits. --}}
                                    @if (Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 2)
                                        <button value="{{$benefiter_medical_visits_list[$i]['id']}}" data-url="{{ url('benefiter/'.$benefiter_medical_visits_list[$i]['benefiter_id'].'/getEachMedicalVisit') }}" type="button" class="medical_visit_from_history btn btn-info btn-lg" data-toggle="modal" data-target="#medicalHistory">@lang($p.('show_medical_visit'))</button>
                                    @endif
                                    </td>
                                    <td>
                                    @if (Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 2)
                                        <a value="{{$benefiter_medical_visits_list[$i]['id']}}" href="{{ url('benefiter/'.$benefiter_medical_visits_list[$i]['benefiter_id'].'/editMedicalVisit?medical_visit_id='.$benefiter_medical_visits_list[$i]['id']) }}" class="btn btn-warning btn-lg" type="button" >
                                            @lang($p.('edit_visit'))
                                        </a>
                                    @endif
                                        @if($benefiter_medical_visits_list[$i]['id'] == $selected_medical_visit_id && $visit_submited_succesfully == 3)
                                            <i class="glyphicon glyphicon-ok updated-visit"></i>
                                    </td>
                                    @endif
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

{{--------------- 3. NEW MEDICAL VISIT ------------------------------------------------}}
{{-- Button (dropsdown the form) --}}
<div class="row padding-top-20">
    <div class="col-md-12">
        @if (Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 2)
            <button id="new-med-visit-button" class="lighter-green-background new-visit-button float-right padding-left-right-15 margin-30">@lang($p.'new_medical_visit')</button>
        @endif
    </div>
</div>
{{-- New medical visit form --}}
<div id="new-medical-visit" class="basic-info-form">
    {!! Form::model($benefiter_medical_visits_list, array('url' => 'benefiter/'.$benefiter->id.'/medical-folder', 'files'=>true, 'id'=>'medical_visit_submit')) !!}
        {{-- get the benefiter id --}}
        {!! Form::hidden('benefiter_id', $benefiter->id) !!}
        {{-- get the doctor id --}}
        {!! Form::hidden('doctor_id', $doctor_id) !!}
            @include('partials.forms.medical-visit.medical_visit_partial_form')
        {{-- SUBMIT --}}
        <div class="form-section align-text-center">
            {!! Form::submit(Lang::get($p.'save_medical_visit'), array('class' => 'submit-button')) !!}
        </div>
    {!! Form::close() !!}
    {{--</div>--}}
</div>


{{--------------- 4. MODAL: Display Medical visit info from history FOR LATER ---------}}
<div class="modal fade" id="medicalHistory" role="dialog" tabindex=-1">
    <div class="modal-dialog width-1200">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title" style="text-align: center; font-weight: bold;">@lang($p.('medical_visit'))</h2>
            </div>
            <div class="modal-body" id="medical-visit-modal-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
