<?php
    $p = "basic_info_form.";
    $t = "language_list.";
?>
<div class="basic-info-form">
<?php
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
{!! Form::model($benefiter, array('url' => 'benefiter/'.$benefiter->id.'/basic-info')) !!}
{{-- if the user is neither admin, nor social advisor disable fields --}}
@if(\Auth::user()->user_role_id != 1 and \Auth::user()->user_role_id != 4)
    <div class="personal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. @lang($p."personal_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('folder_number', Lang::get('basic_info_form.folder_number')) !!}<i class="fa fa-asterisk asterisk"></i>
                            {!! Form::text('folder_number', null, array('class' => 'custom-input-text text-align-right', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('lastname', Lang::get('basic_info_form.lastname')) !!}<i class="fa fa-asterisk asterisk"></i>
                            {!! Form::text('lastname', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('name', Lang::get('basic_info_form.name')) !!}<i class="fa fa-asterisk asterisk"></i>
                            {!! Form::text('name', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('gender_id', Lang::get('basic_info_form.gender')) !!}
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
                                {!! Form::radio('gender_id', 1, $male, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('gender_id', Lang::get('basic_info_form.male'), array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender_id', 2, $female, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('gender_id', Lang::get('basic_info_form.female'), array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender_id', 3, $other, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('gender_id', Lang::get('basic_info_form.other'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label(Lang::get('basic_info_form.birth_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('birth_date', null, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('fathers_name', Lang::get('basic_info_form.fathers_name')) !!}
                            {!! Form::text('fathers_name', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('mothers_name', Lang::get('basic_info_form.mothers_name')) !!}
                            {!! Form::text('mothers_name', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('nationality_country', Lang::get('basic_info_form.nationality_country')) !!}
                            {!! Form::text('nationality_country', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('origin_country', Lang::get('basic_info_form.origin_country')) !!}
                            {!! Form::text('origin_country', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('ethnic_group', Lang::get('basic_info_form.ethnic_group')) !!}
                            {!! Form::text('ethnic_group', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('arrival_date', Lang::get('basic_info_form.arrival_date')) !!}
                            {!! Form::text('arrival_date', null, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('telephone', Lang::get('basic_info_form.telephone')) !!}
                            <?php
                                if($benefiter->telephone == 0){
                                    $benefiter->telephone = "";
                                }
                            ?>
                            {!! Form::text('telephone', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-6">
                            {!! Form::label('address', Lang::get('basic_info_form.address')) !!}
                            {!! Form::text('address', null, array('class' => 'custom-input-text address', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="family-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. @lang($p."family_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group float-left width-100-percent">
                            <?php
                                $marital_status[0] = true;
                                for($i = 1; $i < 5; $i++){
                                    $marital_status[$i] = false;
                                }
                                $marital_status[$benefiter->marital_status_id -1] = true;
                            ?>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 1, $marital_status[0], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('marital_status', Lang::get('basic_info_form.unmarried'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 2, $marital_status[1], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('marital_status', Lang::get('basic_info_form.married'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 3, $marital_status[2], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('marital_status', Lang::get('basic_info_form.divorced'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 4, $marital_status[3], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('marital_status', Lang::get('basic_info_form.widower'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 5, $marital_status[4], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('marital_status', Lang::get('basic_info_form.estranged'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('number_of_children', Lang::get('basic_info_form.number_of_children')) !!}
                            <?php
                                if($benefiter->number_of_children == 0){
                                    $benefiter->number_of_children = "";
                                }
                            ?>
                            {!! Form::text('number_of_children', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-6">
                            {!! Form::label('relatives_residence', Lang::get('basic_info_form.relatives_residence')) !!}
                            {!! Form::text('relatives_residence', null, array('class' => 'custom-input-text address', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-12">
                            {!! Form::label('children_names', Lang::get('basic_info_form.children_names')) !!}
                        @if(empty($benefiter->children_names))
                            {!! Form::textarea('children_names', null, array('class' => 'custom-input-textarea width-100-percent non-printable', 'disabled' => 'disabled')) !!}
                        @else
                            {!! Form::textarea('children_names', null, array('class' => 'custom-input-textarea width-100-percent', 'disabled' => 'disabled')) !!}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="legal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. @lang($p."legal_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    for($i = 0; $i < 8; $i++){
                        $legal_status[$i] = false;
                        $legal_status_text[$i] = "";
                        $legal_status_exp_date[$i] = "";
                    }
                    if(isset($legalStatuses) and $legalStatuses != null){
                        foreach($legalStatuses as $status){
                            $id = $status->legal_lookup_id - 1;
                            $legal_status[$id] = true;
                            $legal_status_text[$id] = $status->description;
                            $legal_status_exp_date[$id] = $datesHelper->getFinelyFormattedStringDateFromDBDate($status->exp_date);
                        }
                    }
                ?>
                <div class="row @if(!$legal_status[0]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 1, $legal_status[0], array('class' => 'float-left', 'tabindex' => '1', 'disabled' => 'disabled')) !!}
                            {!! Form::label('deportation', Lang::get('basic_info_form.deportation'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[0], array('class' => 'custom-input-text make-inline float-left', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[0], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '1', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[1]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 2, $legal_status[1], array('class' => 'float-left', 'tabindex' => '2', 'disabled' => 'disabled')) !!}
                            {!! Form::label('asylum_application', Lang::get('basic_info_form.asylum_application'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[1], array('class' => 'custom-input-text float-left', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[1], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '2', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[2]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 3, $legal_status[2], array('class' => 'float-left', 'tabindex' => '3', 'disabled' => 'disabled')) !!}
                            {!! Form::label('refugee', Lang::get('basic_info_form.refugee'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[2], array('class' => 'custom-input-text float-left', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[2], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '3', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[3]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 4, $legal_status[3], array('class' => 'float-left', 'tabindex' => '4', 'disabled' => 'disabled')) !!}
                            {!! Form::label('residence_permit', Lang::get('basic_info_form.residence_permit'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[3], array('class' => 'custom-input-text float-left', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[3], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '4', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[4]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 5, $legal_status[4], array('class' => 'float-left', 'tabindex' => '5', 'disabled' => 'disabled')) !!}
                            {!! Form::label('immigrant_residence_permit', Lang::get('basic_info_form.immigrant_residence_permit'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[4], array('class' => 'custom-input-text float-left', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[4], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '5', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[5]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 6, $legal_status[5], array('class' => 'float-left', 'tabindex' => '6', 'disabled' => 'disabled')) !!}
                            {!! Form::label('european', Lang::get('basic_info_form.european'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[5], array('class' => 'custom-input-text float-left', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[5], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '6', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[6]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 7, $legal_status[6], array('class' => 'float-left', 'tabindex' => '7', 'disabled' => 'disabled')) !!}
                            {!! Form::label('humanitarian', Lang::get('basic_info_form.humanitarian'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[6], array('class' => 'custom-input-text float-left', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[6], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '7', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[7]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 8, $legal_status[7], array('class' => 'float-left', 'tabindex' => '8', 'disabled' => 'disabled')) !!}
                            {!! Form::label('out_of_legal', Lang::get('basic_info_form.out_of_legal'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[7], array('class' => 'custom-input-text float-left', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 hide">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[7], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '8', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="education-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">4. @lang($p."education_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group float-left width-100-percent">
                            <?php
                                $education[0] = true;
                                for($i = 1; $i < 9; $i++){
                                    $education[$i] = false;
                                }
                                $education[$benefiter->education_id - 1] = true;
                            ?>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 1, $education[0], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.illiterate'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 2, $education[1], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.elementary'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 3, $education[2], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.middle'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 4, $education[3], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.high'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 5, $education[4], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.professional_high'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 6, $education[5], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.tei'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 7, $education[6], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.aei'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 8, $education[7], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.master'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 9, $education[8], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                {!! Form::label('education_status', Lang::get('basic_info_form.phd'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="languages-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">5. @lang($p."languages_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="language-wrapper" class="row">
                <?php
                    // if there are available languages selected
                    if(isset($benefiter_languages) and $benefiter_languages != null){
                        $counter = -1;
                        foreach($benefiter_languages as $benefiter_language){
                            if ($counter == -1){
                    echo '<div class="padding-left-right-15 language-div">';
                            } else {
                    echo '<div class="padding-left-right-15 added-div">';
                            }
                            $counter++;
                ?>
                        <div class="form-group float-left width-100-percent @if($benefiter_language->language_id == 1) non-printable @endif">
                            <div class="col-md-3 make-inline">
                                <select disabled name="language{{$counter}}" class="language-selection">
                                    @foreach($languages as $language)
                                    <?php $selected = "";?>
                                    @if($benefiter_language->language_id == $language->id)
                                        <?php $selected = "selected"; ?>
                                    @endif
                                    <option value="{{ $language->id }}" {{ $selected }}>@lang($t.$language->description)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 make-inline @if(empty($benefiter_language->language_level_id) or $benefiter_language->language_level_id == 1) non-printable @endif">
                                <select disabled name="language_level{{$counter}}" class="make-inline level-selection">
                                    <?php
                                        $first = true;
                                    ?>
                                    @foreach($languageLevels as $level)
                                    <?php $selected = "";?>
                                    @if($benefiter_language->language_level_id == $level->id)
                                        <?php $selected = "selected"; ?>
                                    @endif
                                    <option value="{{ $level->id }}" {{ $selected }}>{{ $level->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    } else { // if there are not selected languages available
                ?>
                    <div class="padding-left-right-15 language-div non-printable">
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-3 make-inline">
                                <select disabled name="language" class="language-selection">
                                    <?php
                                        $first = true;
                                    ?>
                                    @foreach($languages as $language)
                                    <?php $selected = "";?>
                                    @if($first)
                                        <?php $selected = "selected";
                                              $first = false;
                                        ?>
                                    @endif
                                    <option value="{{ $language->id }}" {{ $selected }}>@lang($t.$language->description)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 make-inline">
                                <select disabled name="language_level" class="make-inline level-selection">
                                    <?php
                                        $first = true;
                                    ?>
                                    @foreach($languageLevels as $level)
                                    <?php $selected = "";?>
                                    @if($first)
                                        <?php $selected = "selected";
                                              $first = false;
                                        ?>
                                    @endif
                                    <option value="{{ $level->id }}" {{ $selected }}>{{ $level->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <?php
                            // initialize interpreter checkbox to be unchecked
                            $interpreter = false;
                            // if benefiter is not new and interpreter is needed then check it
                            if($benefiter->id != -1 && $benefiter->language_interpreter_needed == 1){
                                $interpreter = true;
                            }
                        ?>
                        <div class="form-group float-left padding-left-right-15 width-100-percent">
                            {!! Form::checkbox('interpreter', true, $interpreter, array('class' => 'float-left', 'disabled' => 'disabled')) !!}
                            {!! Form::label('interpreter', Lang::get('basic_info_form.interpreter'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="work-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">6. @lang($p."work_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <?php
                            // initialized values for work radiobox
                            $working = true;
                            $not_working = false;
                            // if benefiter is not new and is not working change the initialized values
                            if($benefiter->id != -1 && $benefiter->is_benefiter_working == 2){
                                $not_working = true;
                            }
                            // initialized values for working legally radiobox
                            $working_legally = true;
                            $working_illegally = false;
                            // check if benefiter is not new and if (s)he is working illegally change initialized values
                            if($benefiter->id != -1 && $benefiter->working_legally == 2){
                                $working_illegally = true;
                            }
                        ?>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working', 1, $working, array('id' => 'show_work_legally', 'disabled' => 'disabled')) !!}
                            {!! Form::label('working', Lang::get('basic_info_form.yes'), array('class' => 'radio-value')) !!}
                        </div>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working', 2, $not_working, array('id' => 'hide_work_legally', 'disabled' => 'disabled')) !!}
                            {!! Form::label('working', Lang::get('basic_info_form.no'), array('class' => 'radio-value')) !!}
                        </div>
                        <div id="working_title_div" class="form-group float-left col-md-8">
                            {!! Form::label('working_title', Lang::get('basic_info_form.working_title'), array('class' => 'make-inline')) !!}
                            {!! Form::text('working_title', $workTitle, array('class' => 'custom-input-text display-inline', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
                <div id="working_legally_div" class="row">
                    <div class="padding-left-right-15">
                        <span class="float-left padding-left-right-15">@lang($p."working")</span>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working_legally', 1, $working_legally, array('disabled' => 'disabled')) !!}
                            {!! Form::label('working_legally', Lang::get('basic_info_form.legally'), array('class' => 'radio-value')) !!}
                        </div>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working_legally', 2, $working_illegally, array('disabled' => 'disabled')) !!}
                            {!! Form::label('working_legally', Lang::get('basic_info_form.illegally'), array('class' => 'radio-value')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="country-abandon-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">7. @lang($p."country_abandon_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            {!! Form::text('country_abandon_reason', null, array('class' => 'custom-input-text width-100-percent', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="travel-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">8. @lang($p."voyage")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            {!! Form::label('travel_route', Lang::get('basic_info_form.travel_route')) !!}
                            {!! Form::text('travel_route', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group padding-left-right-15">
                            {!! Form::label('travel_duration', Lang::get('basic_info_form.travel_duration')) !!}
                            {!! Form::text('travel_duration', null, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="detention-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">9. @lang($p."detention_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            {!! Form::text('detention_duration', null, array('class' => 'custom-input-text width-100-percent', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="social-background-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">10. @lang($p."social_background_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                        @if(empty($benefiter->social_history))
                            {!! Form::textarea('social_history', null, array('class' => 'custom-input-textarea width-100-percent non-printable', 'disabled' => 'disabled')) !!}
                        @else
                            {!! Form::textarea('social_history', null, array('class' => 'custom-input-textarea width-100-percent', 'disabled' => 'disabled')) !!}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
    {{-- BASIC INFO REFERRALS --}}
    @if($benefiter->id == -1)
        <div class="form-section no-bottom-border">
            <div class="col-md-12 referral-info">
                <p>@lang($p."referral_info")</p>
            </div>
        </div>
    @else
        {{-- REFERRALS --}}
        <div class="referrals-list form-section no-bottom-border">
            <div class="underline-header">
                <h1 class="record-section-header padding-left-right-15">11. @lang($p."referrals")</h1>
            </div>
            {{-- OLDER REFERRALS LIST --}}
            <div class="row">
                <div class="col-md-12">
                    <div id="basic_info_referrals-list" class="row padding-bottom-30">
                        <div class="no-margin pos-relative" id="results-to-activate">
                            <div class="display padding-20">
                                <table id="benefiter_referrals_history" class="display" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>@lang($p."counter")</th>
                                        <th>@lang($p."referral")</th>
                                        <th>@lang($p."description")</th>
                                        <th>@lang($p."referral_date")</th>
                                        <th>@lang($p."referrer")</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $counter = 1;
                                    ?>
                                    @foreach($benefiter_referrals_list as $referral)
                                    @if(!empty($referral))
                                        <tr>
                                            <td><?php
                                                    echo $counter;
                                                    $counter++;
                                                ?>
                                            </td>
                                            <td>{{ $referral['referralType']['description'] }}</td>
                                            <td>{{ $referral['description'] }}</td>
                                            <td>{{ $datesHelper->getFinelyFormattedStringDateFromDBDate($referral['referral_date']) }}</td>
                                            <td>{{ $referral['name'] . ' ' . $referral['lastname'] }}</td>
                                            <td>
                                                <button class="delete-session btn btn-warning btn-lg" name="{{ $referral->id }}">@lang($p."delete_referral")</button>
                                            </td>
                                        </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>@lang($p."counter")</th>
                                        <th>@lang($p."referral")</th>
                                        <th>@lang($p."description")</th>
                                        <th>@lang($p."referral_date")</th>
                                        <th>@lang($p."referrer")</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-new-referral form-section no-bottom-border">
             <div class="underline-header">
                <h1 class="record-section-header padding-left-right-15">12. @lang($p."new_referral")</h1>
            </div>
            {!! Form::model($benefiter, array('url' => 'benefiter/'.$benefiter->id.'/basic-info/referrals')) !!}
                {!! Form::hidden('benefiter_id', $benefiter->id) !!}
                {{-- ADD NEW REFERRAL --}}
                <div class="row">
                    <div class="col-md-12">
                        <div id="basic_info_referrals" class="row padding-bottom-30">
                            <div  class="padding-left-right-15 basic_info_referral">
                                <div class="form-group float-left width-100-percent">

                                    {{-- ΠΑΡΑΠΟΜΠΗ --}}
                                    <div class="form-group make-inline float-left col-md-9">
                                        {!! Form::label('basic_info_referrals', Lang::get('basic_info_form.referral_label')) !!}
                                        {!! Form::select('basic_info_referrals_id[]', $basic_info_referral_array) !!}
                                        {!! Form::text('basic_info_referrals_text[]', null, array('id'=>'basic_info_refList', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                    </div>
                                    <div class="form-group make-inline float-left col-md-2">
                                        {!! Form::text('basic_info_referrals_date[]', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                                    </div>
                                    <div class="col-md-1">
                                        {{-- add --}}
                                        <a class="color-green add-ref float-right" href="javascript:void(0)">
                                            <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                        </a>
                                        {{-- remove --}}
                                        <a class="color-red remove-ref hide-element float-right" href="javascript:void(0)">
                                            <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-section align-text-center no-bottom-border">
                    {!! Form::submit(Lang::get('basic_info_form.save_referral'), array('class' => 'submit-button')) !!}
                </div>
            {!! Form::close() !!}
    @endif
@else
    <div class="personal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. @lang($p."personal_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('folder_number', Lang::get('basic_info_form.folder_number')) !!} <i class="fa fa-asterisk asterisk"></i>
                            {!! Form::text('folder_number', null, array('class' => 'custom-input-text text-align-right')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('lastname', Lang::get('basic_info_form.lastname')) !!}<i class="fa fa-asterisk asterisk"></i>
                            {!! Form::text('lastname', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('name', Lang::get('basic_info_form.name')) !!}<i class="fa fa-asterisk asterisk"></i>
                            {!! Form::text('name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('gender_id', Lang::get('basic_info_form.gender')) !!}
                            <?php
                                $male = true;
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
                                {!! Form::radio('gender_id', 1, $male, array('class' => 'make-inline', 'id' => 'male')) !!}
                                {!! Form::label('male', Lang::get('basic_info_form.male'), array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender_id', 2, $female, array('class' => 'make-inline', 'id' => 'female')) !!}
                                {!! Form::label('female', Lang::get('basic_info_form.female'), array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender_id', 3, $other, array('class' => 'make-inline', 'id' => 'other')) !!}
                                {!! Form::label('other', Lang::get('basic_info_form.other'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label(Lang::get('basic_info_form.birth_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('birth_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('fathers_name', Lang::get('basic_info_form.fathers_name')) !!}
                            {!! Form::text('fathers_name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('mothers_name', Lang::get('basic_info_form.mothers_name')) !!}
                            {!! Form::text('mothers_name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('nationality_country', Lang::get('basic_info_form.nationality_country')) !!}
                            {!! Form::text('nationality_country', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('origin_country', Lang::get('basic_info_form.origin_country')) !!}
                            {!! Form::text('origin_country', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('ethnic_group', Lang::get('basic_info_form.ethnic_group')) !!}
                            {!! Form::text('ethnic_group', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('arrival_date', Lang::get('basic_info_form.arrival_date')) !!}
                            {!! Form::text('arrival_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-2">
                            {!! Form::label('telephone', Lang::get('basic_info_form.telephone')) !!}
                            <?php
                                if($benefiter->telephone == 0){
                                    $benefiter->telephone = "";
                                }
                            ?>
                            {!! Form::text('telephone', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-xs-6">
                            {!! Form::label('address', Lang::get('basic_info_form.address')) !!}
                            {!! Form::text('address', null, array('class' => 'custom-input-text address')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="family-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. @lang($p."family_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group float-left width-100-percent">
                            <?php
                                $marital_status[0] = true;
                                for($i = 1; $i < 5; $i++){
                                    $marital_status[$i] = false;
                                }
                                $marital_status[$benefiter->marital_status_id -1] = true;
                            ?>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 1, $marital_status[0], array('class' => 'make-inline', 'id' => 'unmarried')) !!}
                                {!! Form::label('unmarried', Lang::get('basic_info_form.unmarried'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 2, $marital_status[1], array('class' => 'make-inline', 'id' => 'married')) !!}
                                {!! Form::label('married', Lang::get('basic_info_form.married'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 3, $marital_status[2], array('class' => 'make-inline', 'id' => 'divorced')) !!}
                                {!! Form::label('divorced', Lang::get('basic_info_form.divorced'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 4, $marital_status[3], array('class' => 'make-inline', 'id' => 'widowed')) !!}
                                {!! Form::label('widowed', Lang::get('basic_info_form.widower'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 5, $marital_status[4], array('class' => 'make-inline', 'id' => 'estranged')) !!}
                                {!! Form::label('estranged', Lang::get('basic_info_form.estranged'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('number_of_children', Lang::get('basic_info_form.number_of_children')) !!}
                            <?php
                                if($benefiter->number_of_children == 0){
                                    $benefiter->number_of_children = "";
                                }
                            ?>
                            {!! Form::text('number_of_children', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-6">
                            {!! Form::label('relatives_residence', Lang::get('basic_info_form.relatives_residence')) !!}
                            {!! Form::text('relatives_residence', null, array('class' => 'custom-input-text address')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-12">
                            {!! Form::label('children_names', Lang::get('basic_info_form.children_names')) !!}
                        @if(empty($benefiter->children_names))
                            {!! Form::textarea('children_names', null, array('class' => 'custom-input-textarea width-100-percent non-printable')) !!}
                        @else
                            {!! Form::textarea('children_names', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="legal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. @lang($p."legal_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    for($i = 0; $i < 8; $i++){
                        $legal_status[$i] = false;
                        $legal_status_text[$i] = "";
                        $legal_status_exp_date[$i] = "";
                    }
                    if(isset($legalStatuses) and $legalStatuses != null){
                        foreach($legalStatuses as $status){
                            $id = $status->legal_lookup_id - 1;
                            $legal_status[$id] = true;
                            $legal_status_text[$id] = $status->description;
                            $legal_status_exp_date[$id] = $datesHelper->getFinelyFormattedStringDateFromDBDate($status->exp_date);
                        }
                    }
                ?>
                <div class="row @if(!$legal_status[0]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 1, $legal_status[0], array('class' => 'float-left', 'tabindex' => '1', 'id' => 'deportation')) !!}
                            {!! Form::label('deportation', Lang::get('basic_info_form.deportation'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[0], array('class' => 'custom-input-text make-inline float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[0], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '1')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[1]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 2, $legal_status[1], array('class' => 'float-left', 'tabindex' => '2', 'id' => 'asylum_application')) !!}
                            {!! Form::label('asylum_application', Lang::get('basic_info_form.asylum_application'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[1], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[1], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '2')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[2]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 3, $legal_status[2], array('class' => 'float-left', 'tabindex' => '3', 'id' => 'refugee')) !!}
                            {!! Form::label('refugee', Lang::get('basic_info_form.refugee'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[2], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[2], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '3')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[3]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 4, $legal_status[3], array('class' => 'float-left', 'tabindex' => '4', 'id' => 'residence_permit')) !!}
                            {!! Form::label('residence_permit', Lang::get('basic_info_form.residence_permit'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[3], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[3], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '4')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[4]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 5, $legal_status[4], array('class' => 'float-left', 'tabindex' => '5', 'id' => 'immigrant_residence_permit')) !!}
                            {!! Form::label('immigrant_residence_permit', Lang::get('basic_info_form.immigrant_residence_permit'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[4], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[4], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '5')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[5]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 6, $legal_status[5], array('class' => 'float-left', 'tabindex' => '6', 'id' => 'european')) !!}
                            {!! Form::label('european', Lang::get('basic_info_form.european'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[5], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[5], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '6')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[6]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 7, $legal_status[6], array('class' => 'float-left', 'tabindex' => '7', 'id' => 'humanitarian')) !!}
                            {!! Form::label('humanitarian', Lang::get('basic_info_form.humanitarian'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[6], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[6], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '7')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row @if(!$legal_status[7]) non-printable @endif">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 8, $legal_status[7], array('class' => 'float-left', 'tabindex' => '8', 'id' => 'out_of_legal')) !!}
                            {!! Form::label('out_of_legal', Lang::get('basic_info_form.out_of_legal'), array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[7], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 hide">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label(Lang::get('basic_info_form.exp_date')) !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[7], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '8')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="education-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">4. @lang($p."education_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group float-left width-100-percent">
                            <?php
                                $education[0] = true;
                                for($i = 1; $i < 9; $i++){
                                    $education[$i] = false;
                                }
                                $education[$benefiter->education_id - 1] = true;
                            ?>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 1, $education[0], array('class' => 'make-inline', 'id' => 'illiterate')) !!}
                                {!! Form::label('illiterate', Lang::get('basic_info_form.illiterate'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 2, $education[1], array('class' => 'make-inline', 'id' => 'elementary')) !!}
                                {!! Form::label('elementary', Lang::get('basic_info_form.elementary'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 3, $education[2], array('class' => 'make-inline', 'id' => 'middle')) !!}
                                {!! Form::label('middle', Lang::get('basic_info_form.middle'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 4, $education[3], array('class' => 'make-inline', 'id' => 'high')) !!}
                                {!! Form::label('high', Lang::get('basic_info_form.high'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 5, $education[4], array('class' => 'make-inline', 'id' => 'professional_high')) !!}
                                {!! Form::label('professional_high', Lang::get('basic_info_form.professional_high'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 6, $education[5], array('class' => 'make-inline', 'id' => 'tei')) !!}
                                {!! Form::label('tei', Lang::get('basic_info_form.tei'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 7, $education[6], array('class' => 'make-inline', 'id' => 'aei')) !!}
                                {!! Form::label('aei', Lang::get('basic_info_form.aei'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 8, $education[7], array('class' => 'make-inline', 'id' => 'master')) !!}
                                {!! Form::label('master', Lang::get('basic_info_form.master'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 9, $education[8], array('class' => 'make-inline', 'id' => 'phd')) !!}
                                {!! Form::label('phd', Lang::get('basic_info_form.phd'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-12 margin-top-20">
                                <div class="form-group width-100-percent">
                                    {!! Form::label('education_specialization', Lang::get('basic_info_form.education_specialization'), array('class' => 'width-20-percent make-inline col-md-1 no-padding')) !!}
                                    {!! Form::text('education_specialization', null, array('class' => 'custom-input-text col-md-11 no-padding')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="languages-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">5. @lang($p."languages_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="language-wrapper" class="row">
                <?php
                    // if there are available languages selected
                    if(isset($benefiter_languages) and $benefiter_languages != null){
                        $counter = -1;
                        foreach($benefiter_languages as $benefiter_language){
                            if ($counter == -1){
                    echo '<div class="padding-left-right-15 language-div">';
                            } else {
                    echo '<div class="padding-left-right-15 added-div">';
                            }
                            $counter++;
                ?>
                        <div class="form-group float-left width-100-percent @if($benefiter_language->language_id == 1) non-printable @endif">
                            <div class="col-md-3 make-inline">
                                <select name="language{{$counter}}" class="language-selection">
                                    @foreach($languages as $language)
                                    <?php $selected = "";?>
                                    @if($benefiter_language->language_id == $language->id)
                                        <?php $selected = "selected"; ?>
                                    @endif
                                    <option value="{{ $language->id }}" {{ $selected }}>@lang($t.$language->description)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 make-inline @if(empty($benefiter_language->language_level_id) or $benefiter_language->language_level_id == 1) non-printable @endif">
                                <select name="language_level{{$counter}}" class="make-inline level-selection">
                                    <?php
                                        $first = true;
                                    ?>
                                    @foreach($languageLevels as $level)
                                    <?php $selected = "";?>
                                    @if($benefiter_language->language_level_id == $level->id)
                                        <?php $selected = "selected"; ?>
                                    @endif
                                    <option value="{{ $level->id }}" {{ $selected }}>{{ $level->description }}</option>
                                    @endforeach
                                </select>
                                <a class="color-green add-lang" href="javascript:void(0)"><span class="glyphicon glyphicon-plus-sign make-inline"></span></a>
                                <a class="color-red remove-lang hide-element" href="javascript:void(0)"><span class="glyphicon glyphicon-minus-sign make-inline"></span></a>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    } else { // if there are not selected languages available
                ?>
                    <div class="padding-left-right-15 language-div">
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-3 make-inline">
                                <select name="language" class="language-selection">
                                    <?php
                                        $first = true;
                                    ?>
                                    @foreach($languages as $language)
                                    <?php $selected = "";?>
                                    @if($first)
                                        <?php $selected = "selected";
                                              $first = false;
                                        ?>
                                    @endif
                                    <option value="{{ $language->id }}" {{ $selected }}>@lang($t.$language->description)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 make-inline">
                                <select name="language_level" class="make-inline level-selection">
                                    <?php
                                        $first = true;
                                    ?>
                                    @foreach($languageLevels as $level)
                                    <?php $selected = "";?>
                                    @if($first)
                                        <?php $selected = "selected";
                                              $first = false;
                                        ?>
                                    @endif
                                    <option value="{{ $level->id }}" {{ $selected }}>{{ $level->description }}</option>
                                    @endforeach
                                </select>
                                <a class="color-green add-lang" href="javascript:void(0)"><span class="glyphicon glyphicon-plus-sign make-inline"></span></a>
                                <a class="color-red remove-lang hide-element" href="javascript:void(0)"><span class="glyphicon glyphicon-minus-sign make-inline"></span></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <?php
                            // initialize interpreter checkbox to be unchecked
                            $interpreter = false;
                            // if benefiter is not new and interpreter is needed then check it
                            if($benefiter->id != -1 && $benefiter->language_interpreter_needed == 1){
                                $interpreter = true;
                            }
                        ?>
                        <div class="form-group float-left padding-left-right-15 width-100-percent">
                            {!! Form::checkbox('interpreter', true, $interpreter, array('class' => 'float-left', 'id' => 'interpreter')) !!}
                            {!! Form::label('interpreter', Lang::get('basic_info_form.interpreter'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="work-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">6. @lang($p."work_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <?php
                            // initialized values for work radiobox
                            $working = true;
                            $not_working = false;
                            // if benefiter is not new and is not working change the initialized values
                            if($benefiter->id != -1 && $benefiter->is_benefiter_working == 2){
                                $not_working = true;
                            }
                            // initialized values for working legally radiobox
                            $working_legally = true;
                            $working_illegally = false;
                            // check if benefiter is not new and if (s)he is working illegally change initialized values
                            if($benefiter->id != -1 && $benefiter->working_legally == 2){
                                $working_illegally = true;
                            }
                        ?>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working', 1, $working, array('id' => 'show_work_legally')) !!}
                            {!! Form::label('show_work_legally', Lang::get('basic_info_form.yes'), array('class' => 'radio-value')) !!}
                        </div>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working', 2, $not_working, array('id' => 'hide_work_legally')) !!}
                            {!! Form::label('hide_work_legally', Lang::get('basic_info_form.no'), array('class' => 'radio-value')) !!}
                        </div>
                        <div id="working_title_div" class="form-group float-left col-md-8">
                            {!! Form::label('working_title', Lang::get('basic_info_form.working_title'), array('class' => 'make-inline')) !!}
                            {!! Form::text('working_title', $workTitle, array('class' => 'custom-input-text display-inline')) !!}
                        </div>
                    </div>
                </div>
                <div id="working_legally_div" class="row">
                    <div class="padding-left-right-15">
                        <span class="float-left padding-left-right-15">@lang($p."working")</span>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working_legally', 1, $working_legally, array('id' => 'legally')) !!}
                            {!! Form::label('legally', Lang::get('basic_info_form.legally'), array('class' => 'radio-value')) !!}
                        </div>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working_legally', 2, $working_illegally, array('id' => 'illegally')) !!}
                            {!! Form::label('illegally', Lang::get('basic_info_form.illegally'), array('class' => 'radio-value')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="country-abandon-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">7. @lang($p."country_abandon_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            <select name="country_abandon_reason" class="abandon-reason-selection">
                                <?php
                                    $first = true;
                                ?>
                                @foreach($country_abandon_reasons as $country_abandon_reason)
                                <?php $selected = "";?>
                                @if($benefiter->country_abandon_reason_id == $country_abandon_reason->id)
                                    <?php $selected = "selected"; ?>
                                @endif
                                <option value="{{ $country_abandon_reason->id }}" {{ $selected }}>{{ $country_abandon_reason->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="travel-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">8. @lang($p."voyage")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            {!! Form::label('travel_route', Lang::get('basic_info_form.travel_route')) !!}
                            {!! Form::text('travel_route', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group padding-left-right-15">
                            {!! Form::label('travel_duration', Lang::get('basic_info_form.travel_duration')) !!}
                            {!! Form::text('travel_duration', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="detention-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">9. @lang($p."detention_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            {!! Form::text('detention_duration', null, array('class' => 'custom-input-text width-100-percent')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="social-background-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">10. @lang($p."social_background_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                        @if(empty($benefiter->social_history))
                            {!! Form::textarea('social_history', null, array('class' => 'custom-input-textarea width-100-percent non-printable')) !!}
                        @else
                            {!! Form::textarea('social_history', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section align-text-center no-bottom-border">
    @if($benefiter->id == -1)
        {!! Form::submit(Lang::get('basic_info_form.save_basic_info'), array('class' => 'submit-button')) !!}
    @else
        {!! Form::submit(Lang::get('basic_info_form.update_basic_info'), array('class' => 'submit-button')) !!}
    @endif
    </div>
{!! Form::close() !!}
    {{-- BASIC INFO REFERRALS --}}
    @if($benefiter->id == -1)
        <div class="form-section no-bottom-border">
            <div class="col-md-12 referral-info">
                <p>@lang($p."referral_info")</p>
            </div>
        </div>
    @else
        {{-- REFERRALS --}}
        <div class="referrals-list form-section no-bottom-border">
            <div class="underline-header">
                <h1 class="record-section-header padding-left-right-15">11. @lang($p."referrals")</h1>
            </div>
            {{-- OLDER REFERRALS LIST --}}
            <div class="row">
                <div class="col-md-12">
                    <div id="basic_info_referrals-list" class="row padding-bottom-30">
                        <div class="no-margin pos-relative" id="results-to-activate">
                            <div class="display padding-20">
                                <table id="benefiter_referrals_history" class="display" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>@lang($p."counter")</th>
                                        <th>@lang($p."referral")</th>
                                        <th>@lang($p."description")</th>
                                        <th>@lang($p."referral_date")</th>
                                        <th>@lang($p."referrer")</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $counter = 1;
                                    ?>
                                    @foreach($benefiter_referrals_list as $referral)
                                    @if(!empty($referral))
                                        <tr>
                                            <td><?php
                                                    echo $counter;
                                                    $counter++;
                                                ?>
                                            </td>
                                            <td>{{ $referral['referralType']['description'] }}</td>
                                            <td>{{ $referral['description'] }}</td>
                                            <td>{{ $datesHelper->getFinelyFormattedStringDateFromDBDate($referral['referral_date']) }}</td>
                                            <td>{{ $referral['name'] . ' ' . $referral['lastname'] }}</td>
                                            <td>
                                                <button class="delete-session btn btn-warning btn-lg" name="{{ $referral->id }}">@lang($p."delete_referral")</button>
                                            </td>
                                        </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>@lang($p."counter")</th>
                                        <th>@lang($p."referral")</th>
                                        <th>@lang($p."description")</th>
                                        <th>@lang($p."referral_date")</th>
                                        <th>@lang($p."referrer")</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-new-referral form-section no-bottom-border">
             <div class="underline-header">
                <h1 class="record-section-header padding-left-right-15">12. @lang($p."new_referral")</h1>
            </div>
            {!! Form::model($benefiter, array('url' => 'benefiter/'.$benefiter->id.'/basic-info/referrals')) !!}
                {!! Form::hidden('benefiter_id', $benefiter->id) !!}
                {{-- ADD NEW REFERRAL --}}
                <div class="row">
                    <div class="col-md-12">
                        <div id="basic_info_referrals" class="row padding-bottom-30">
                            <div  class="padding-left-right-15 basic_info_referral">
                                <div class="form-group float-left width-100-percent">

                                    {{-- ΠΑΡΑΠΟΜΠΗ --}}
                                    <div class="form-group make-inline float-left col-md-9">
                                        {!! Form::label('basic_info_referrals', Lang::get('basic_info_form.referral_label')) !!}
                                        {!! Form::select('basic_info_referrals_id[]', $basic_info_referral_array) !!}
                                        {!! Form::text('basic_info_referrals_text[]', null, array('id'=>'basic_info_refList', 'class' => 'custom-input-text display-inline width-50-percent')) !!}
                                    </div>
                                    <div class="form-group make-inline float-left col-md-2">
                                        {!! Form::text('basic_info_referrals_date[]', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                                    </div>
                                    <div class="col-md-1">
                                        {{-- add --}}
                                        <a class="color-green add-ref float-right" href="javascript:void(0)">
                                            <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                        </a>
                                        {{-- remove --}}
                                        <a class="color-red remove-ref hide-element float-right" href="javascript:void(0)">
                                            <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-section align-text-center no-bottom-border">
                    {!! Form::submit(Lang::get('basic_info_form.save_referral'), array('class' => 'submit-button')) !!}
                </div>
            {!! Form::close() !!}
    @endif
@endif
@if($benefiter->id != -1)
    <div class="form-section padding-left-right-15 print-button">
        <div class="row">
            <a href="javascript:window.print()" class="simple-button float-right"><i class="fa fa-print"></i> @lang($p."print_page")</a>
        </div>
    </div>
@endif
</div>
<!--delete session confirmation modal-->
<div class="modal fade" id="delete-session-modal" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="delete-session-form" action="" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if(!empty($referral))
                <input type="hidden" class="delete-session-path" name="path" value="{{ url("benefiter/".$benefiter->id."/basic-info/referral-delete/".$referral->id) }}">
                @endif
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@lang($p."delete_session_modal_title")</h4>
                </div>
                <div class="modal-footer">
                    <div class="col-md-3 col-md-offset-9">
                        <button type="submit" class="simple-button">@lang($p."done")</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
