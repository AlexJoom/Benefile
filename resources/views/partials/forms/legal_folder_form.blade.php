<div class="legal-folder-form">
<?php
    $p = "legal_folder_form.";
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
{!! Form::open(array('url' => 'benefiter/'.$benefiter->id.'/legal-folder')) !!}
@if (Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 3)

{{--<hr>--}}
    <div class="personal-family-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. @lang("social_folder_form.personal_family_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('folder_number', Lang::get('basic_info_form.folder_number')) !!}
                            {!! Form::text('folder_number', $benefiter->folder_number, array('class' => 'custom-input-text text-align-right', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('lastname', Lang::get('basic_info_form.lastname')) !!}
                            {!! Form::text('lastname', $benefiter->lastname, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('name', Lang::get('basic_info_form.name')) !!}
                            {!! Form::text('name', $benefiter->name, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        {{-- GENDER --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
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
                                    {!! Form::radio('gender_id', 1, $male, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                    {!! Form::label('gender_id', Lang::get('basic_info_form.male'), array('class' => 'radio-value')) !!}
                                    {!! Form::radio('gender_id', 2, $female, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                    {!! Form::label('gender_id', Lang::get('basic_info_form.female'), array('class' => 'radio-value')) !!}
                                    {!! Form::radio('gender_id', 3, $other, array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                    {!! Form::label('gender_id', Lang::get('basic_info_form.other'), array('class' => 'radio-value')) !!}
                                </div>
                            </div>
                        </div>
                        {{-- Birth date --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('birth_date', Lang::get('basic_info_form.birth_date')) !!}
                            {!! Form::text('birth_date', $benefiter->birth_date, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date hide"></span></a>
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
                       {{-- ETHNICITY --}}
                       <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                           {!! Form::label('ethnic_group', Lang::get('basic_info_form.ethnic_group')) !!}
                           {!! Form::text('ethnic_group', $benefiter->ethnic_group, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
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
                        {{-- CHILDRENS NAME --}}
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-4">
                            {!! Form::label('children_names', Lang::get('basic_info_form.children_names')) !!}
                            {!! Form::text('children_names', $benefiter->children_names, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="legal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. @lang($p."legal_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <?php
                            for($i = 0; $i < 2; $i++){
                                $legal_folder_status[$i] = false;
                            }
                            if(isset($legal_folder) and $legal_folder != null){
                                $legal_folder_status[$legal_folder->legal_folder_status_id - 1] = true;
                            } else {
                                $legal_folder_status[0] = true;
                            }
                        ?>
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('legal_folder_status', 1, $legal_folder_status[0], array('class' => 'make-inline', 'id' => 'asylum')) !!}
                                {!! Form::label('legal_folder_status', Lang::get('legal_folder_form.asylum'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('legal_folder_status', 2, $legal_folder_status[1], array('class' => 'make-inline', 'id' => 'no-legal')) !!}
                                {!! Form::label('legal_folder_status', Lang::get('legal_folder_form.no_legal'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="asylum-request dynamic-form-section hide">
                            <h1 class="record-section-header padding-left-right-15">@lang($p."asylum")</h1>
                            <?php
                                $asylum_request_date = null;
                                $request_progress = null;
                                for($i = 0; $i < 2; $i++){
                                    $procedure[$i] = false;
                                }
                                $procedure[0] = true;
                                for($i = 0; $i < 3; $i++){
                                    $request_status[$i] = "";
                                }
                                $request_status[0] = "selected";
                                if(isset($asylum_request) and $asylum_request != null){
                                    $asylum_request_date = $datesHelper->getFinelyFormattedStringDateFromDBDate($asylum_request->request_date);
                                    $procedure[$asylum_request->procedure_id - 1] = true;
                                    $request_status[0] = "";
                                    $request_status[$asylum_request->request_status_id - 1] = "selected";
                                    $request_progress = $asylum_request->request_progress;
                                }
                            ?>
                            <div class="row">
                                <div class="form-group float-left padding-left-right-15 width-100-percent">
                                    <div class="col-md-2 make-inline">
                                        {!! Form::label('asylum_request_date', Lang::get('legal_folder_form.asylum_request_date')) !!}
                                        {!! Form::text('asylum_request_date', $asylum_request_date, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group float-left padding-left-right-15 width-100-percent">
                                    <div class="col-md-2 make-inline">
                                        {!! Form::radio('procedure', 1, $procedure[0], array('class' => 'make-inline', 'id' => 'procedure-old')) !!}
                                        {!! Form::label('procedure', Lang::get('legal_folder_form.procedure_old'), array('class' => 'radio-value')) !!}
                                    </div>
                                    <div class="col-md-2 make-inline">
                                        {!! Form::radio('procedure', 2, $procedure[1], array('class' => 'make-inline', 'id' => 'procedure-new')) !!}
                                        {!! Form::label('procedure', Lang::get('legal_folder_form.procedure_new'), array('class' => 'radio-value')) !!}
                                    </div>
                                    <div class="request-status col-md-6 make-inline hide">
                                        {!! Form::label('request_status', Lang::get('legal_folder_form.request_status')) !!}
                                        <select name="request_status" class="request-status-selection">
                                            <option value="1" {{ $request_status[0] }}>α'</option>
                                            <option value="2" {{ $request_status[1] }}>β'</option>
                                            <option value="3" {{ $request_status[2] }}>μεταγενέστερο</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="padding-left-right-15">
                                    <div class="form-group padding-left-right-15">
                                        {!! Form::label('request_progress', Lang::get('legal_folder_form.request_progress')) !!}
                                        {!! Form::textarea('request_progress', $request_progress, array('class' => 'custom-input-textarea width-100-percent')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="no-legal dynamic-form-section hide">
                            <h1 class="record-section-header padding-left-right-15">@lang($p."no_legal")</h1>
                            <?php
                                for($i = 0; $i < 2; $i++){
                                    $action[$i] = false;
                                }
                                $action[0] = true;
                                for($i = 0; $i < 2; $i++){
                                    $result[$i] = false;
                                }
                                $result[0] = true;
                                if(isset($no_legal_status) and $no_legal_status != null){
                                    $action[$no_legal_status->action_id - 1] = true;
                                    $result[$no_legal_status->result_id - 1] = true;
                                }
                            ?>
                            <div class="row">
                                <div class="form-group padding-left-right-15 float-left width-100-percent">
                                    <div class="col-md-3 make-inline">
                                        {!! Form::radio('action', 1, $action[0], array('class' => 'make-inline', 'id' => 'action-none')) !!}
                                        {!! Form::label('action', Lang::get('legal_folder_form.action_none'), array('class' => 'radio-value')) !!}
                                    </div>
                                    <div class="col-md-3 make-inline">
                                        {!! Form::radio('action', 2, $action[1], array('class' => 'make-inline', 'id' => 'action-refusal')) !!}
                                        {!! Form::label('action', Lang::get('legal_folder_form.action_refusal'), array('class' => 'radio-value')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="results hide">
                                <div class="row">
                                    <div class="form-group padding-left-right-15">
                                        <div class="col-md-1 make-inline">
                                            {!! Form::label('result', Lang::get('legal_folder_form.result')) !!}
                                        </div>
                                        <div class="col-md-2 make-inline">
                                            {!! Form::radio('result', 1, $result[0], array('class' => 'make-inline')) !!}
                                            {!! Form::label('result', Lang::get('legal_folder_form.positive'), array('class' => 'radio-value')) !!}
                                        </div>
                                        <div class="col-md-2 make-inline">
                                            {!! Form::radio('result', 2, $result[1], array('class' => 'make-inline')) !!}
                                            {!! Form::label('result', Lang::get('legal_folder_form.negative'), array('class' => 'radio-value')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="penalties form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. @lang($p."penalties")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    $penalty_text = null;
                    for($i = 0; $i < 2; $i++){
                        $penalty[$i] = false;
                    }
                    $penalty[0] = true;
                    if(isset($legal_folder) and $legal_folder != null){
                        $penalty[$legal_folder->penalty_id - 1] = true;
                        $penalty_text = $legal_folder->penalty_text;
                    }
                ?>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-1 make-inline">
                                {!! Form::label('penalty', Lang::get('legal_folder_form.penalty')) !!}
                            </div>
                            <div class="col-md-1 make-inline">
                                {!! Form::radio('penalty', 1, $penalty[0], array('class' => 'make-inline', 'id' => 'penalty-yes')) !!}
                                {!! Form::label('penalty', Lang::get('legal_folder_form.yes'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-1 make-inline">
                                {!! Form::radio('penalty', 2, $penalty[1], array('class' => 'make-inline', 'id' => 'penalty-no')) !!}
                                {!! Form::label('penalty', Lang::get('legal_folder_form.no'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="penalty-text row hide">
                    <div class="padding-left-right-15">
                        <div class="padding-left-right-15">
                            <div class="form-group float-left width-100-percent">
                                {!! Form::textarea('penalty_text', $penalty_text, array('class' => 'custom-input-textarea width-100-percent')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lawyer-actions form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">4. @lang($p."lawyer_actions")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    for($i = 0; $i < 5; $i++){
                        $lawyer[$i] = false;
                    }
                    if(isset($lawyer_action) and $lawyer_action != null){
                        foreach($lawyer_action as $law_action){
                            $lawyer[$law_action->lawyer_action_id - 1] = true;
                        }
                    }
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 1, $lawyer[0], array('class' => 'float-left')) !!}
                            {!! Form::label('rights_advise', Lang::get('legal_folder_form.rights_advise'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 2, $lawyer[1], array('class' => 'float-left')) !!}
                            {!! Form::label('asylum_advise', Lang::get('legal_folder_form.asylum_advise'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 3, $lawyer[2], array('class' => 'float-left')) !!}
                            {!! Form::label('interview_preparation', Lang::get('legal_folder_form.interview_preparation'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 4, $lawyer[3], array('class' => 'float-left')) !!}
                            {!! Form::label('appeal', Lang::get('legal_folder_form.appeal'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 5, $lawyer[4], array('class' => 'float-left')) !!}
                            {!! Form::label('detention_lift', Lang::get('legal_folder_form.detention_lift'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section align-text-center">
        @if($legal_folder == null)
        {!! Form::submit(Lang::get('legal_folder_form.save_legal_folder'), array('class' => 'submit-button')) !!}
        @else
        {!! Form::submit(Lang::get('legal_folder_form.edit_legal_folder'), array('class' => 'submit-button')) !!}
        @endif
    </div>
@else
    <div class="personal-family-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. @lang("social_folder_form.personal_family_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('folder_number', Lang::get('basic_info_form.folder_number')) !!}
                            {!! Form::text('folder_number', $benefiter->folder_number, array('class' => 'custom-input-text text-align-right', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('lastname', Lang::get('basic_info_form.lastname')) !!}
                            {!! Form::text('lastname', $benefiter->lastname, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('name', Lang::get('basic_info_form.name')) !!}
                            {!! Form::text('name', $benefiter->name, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('fathers_name', Lang::get('basic_info_form.fathers_name')) !!}
                            {!! Form::text('fathers_name', $benefiter->fathers_name, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('children_names', Lang::get('basic_info_form.children_names')) !!}
                            {!! Form::text('children_names', $benefiter->children_names, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('origin_country', Lang::get('basic_info_form.origin_country')) !!}
                            {!! Form::text('origin_country', $benefiter->origin_country, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('ethnic_group', Lang::get('basic_info_form.ethnic_group')) !!}
                            {!! Form::text('ethnic_group', $benefiter->ethnic_group, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('birth_date', Lang::get('basic_info_form.birth_date')) !!}
                            {!! Form::text('birth_date', $benefiter->birth_date, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date hide"></span></a>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('telephone', Lang::get('basic_info_form.telephone')) !!}
                            {!! Form::text('telephone', $benefiter->telephone, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="legal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. @lang($p."legal_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <?php
                            for($i = 0; $i < 2; $i++){
                                $legal_folder_status[$i] = false;
                            }
                            if(isset($legal_folder) and $legal_folder != null){
                                $legal_folder_status[$legal_folder->legal_folder_status_id - 1] = true;
                            } else {
                                $legal_folder_status[0] = true;
                            }
                        ?>
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('legal_folder_status', 1, $legal_folder_status[0], array('class' => 'make-inline', 'id' => 'asylum', 'disabled' => 'disabled')) !!}
                                {!! Form::label('legal_folder_status', Lang::get('legal_folder_form.asylum'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('legal_folder_status', 2, $legal_folder_status[1], array('class' => 'make-inline', 'id' => 'no-legal', 'disabled' => 'disabled')) !!}
                                {!! Form::label('legal_folder_status', Lang::get('legal_folder_form.no_legal'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="asylum-request dynamic-form-section hide">
                            <h1 class="record-section-header padding-left-right-15">@lang($p."asylum")</h1>
                            <?php
                                $asylum_request_date = null;
                                $request_progress = null;
                                for($i = 0; $i < 2; $i++){
                                    $procedure[$i] = false;
                                }
                                $procedure[0] = true;
                                for($i = 0; $i < 3; $i++){
                                    $request_status[$i] = "";
                                }
                                $request_status[0] = "selected";
                                if(isset($asylum_request) and $asylum_request != null){
                                    $asylum_request_date = $datesHelper->getFinelyFormattedStringDateFromDBDate($asylum_request->request_date);
                                    $procedure[$asylum_request->procedure_id - 1] = true;
                                    $request_status[0] = "";
                                    $request_status[$asylum_request->request_status_id - 1] = "selected";
                                    $request_progress = $asylum_request->request_progress;
                                }
                            ?>
                            <div class="row">
                                <div class="form-group float-left padding-left-right-15 width-100-percent">
                                    <div class="col-md-2 make-inline">
                                        {!! Form::label('asylum_request_date', Lang::get('legal_folder_form.asylum_request_date')) !!}
                                        {!! Form::text('asylum_request_date', $asylum_request_date, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group float-left padding-left-right-15 width-100-percent">
                                    <div class="col-md-2 make-inline">
                                        {!! Form::radio('procedure', 1, $procedure[0], array('class' => 'make-inline', 'id' => 'procedure-old', 'disabled' => 'disabled')) !!}
                                        {!! Form::label('procedure', Lang::get('legal_folder_form.procedure_old'), array('class' => 'radio-value')) !!}
                                    </div>
                                    <div class="col-md-2 make-inline">
                                        {!! Form::radio('procedure', 2, $procedure[1], array('class' => 'make-inline', 'id' => 'procedure-new', 'disabled' => 'disabled')) !!}
                                        {!! Form::label('procedure', Lang::get('legal_folder_form.procedure_new'), array('class' => 'radio-value')) !!}
                                    </div>
                                    <div class="request-status col-md-6 make-inline hide">
                                        {!! Form::label('request_status', Lang::get('legal_folder_form.request_status')) !!}
                                        <select name="request_status" class="request-status-selection" disabled>
                                            <option value="1" {{ $request_status[0] }} disabled>α'</option>
                                            <option value="2" {{ $request_status[1] }} disabled>β'</option>
                                            <option value="3" {{ $request_status[2] }} disabled>μεταγενέστερο</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="padding-left-right-15">
                                    <div class="form-group padding-left-right-15">
                                        {!! Form::label('request_progress', Lang::get('legal_folder_form.request_progress')) !!}
                                        {!! Form::textarea('request_progress', $request_progress, array('class' => 'custom-input-textarea width-100-percent', 'disabled' => 'disabled')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="no-legal dynamic-form-section hide">
                            <h1 class="record-section-header padding-left-right-15">@lang($p."no_legal")</h1>
                            <?php
                                for($i = 0; $i < 2; $i++){
                                    $action[$i] = false;
                                }
                                $action[0] = true;
                                for($i = 0; $i < 2; $i++){
                                    $result[$i] = false;
                                }
                                $result[0] = true;
                                if(isset($no_legal_status) and $no_legal_status != null){
                                    $action[$no_legal_status->action_id - 1] = true;
                                    $result[$no_legal_status->result_id - 1] = true;
                                }
                            ?>
                            <div class="row">
                                <div class="form-group padding-left-right-15 float-left width-100-percent">
                                    <div class="col-md-3 make-inline">
                                        {!! Form::radio('action', 1, $action[0], array('class' => 'make-inline', 'id' => 'action-none', 'disabled' => 'disabled')) !!}
                                        {!! Form::label('action', Lang::get('legal_folder_form.action_none'), array('class' => 'radio-value')) !!}
                                    </div>
                                    <div class="col-md-3 make-inline">
                                        {!! Form::radio('action', 2, $action[1], array('class' => 'make-inline', 'id' => 'action-refusal', 'disabled' => 'disabled')) !!}
                                        {!! Form::label('action', Lang::get('legal_folder_form.action_refusal'), array('class' => 'radio-value')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="results hide">
                                <div class="row">
                                    <div class="form-group padding-left-right-15">
                                        <div class="col-md-1 make-inline">
                                            {!! Form::label('result', Lang::get('legal_folder_form.result')) !!}
                                        </div>
                                        <div class="col-md-2 make-inline">
                                            {!! Form::radio('result', 1, $result[0], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                            {!! Form::label('result', Lang::get('legal_folder_form.positive'), array('class' => 'radio-value')) !!}
                                        </div>
                                        <div class="col-md-2 make-inline">
                                            {!! Form::radio('result', 2, $result[1], array('class' => 'make-inline', 'disabled' => 'disabled')) !!}
                                            {!! Form::label('result', Lang::get('legal_folder_form.negative'), array('class' => 'radio-value')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="penalties form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. @lang($p."penalties")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    $penalty_text = null;
                    for($i = 0; $i < 2; $i++){
                        $penalty[$i] = false;
                    }
                    $penalty[0] = true;
                    if(isset($legal_folder) and $legal_folder != null){
                        $penalty[$legal_folder->penalty_id - 1] = true;
                        $penalty_text = $legal_folder->penalty_text;
                    }
                ?>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-1 make-inline">
                                {!! Form::label('penalty', Lang::get('legal_folder_form.penalty')) !!}
                            </div>
                            <div class="col-md-1 make-inline">
                                {!! Form::radio('penalty', 1, $penalty[0], array('class' => 'make-inline', 'id' => 'penalty-yes', 'disabled' => 'disabled')) !!}
                                {!! Form::label('penalty', Lang::get('legal_folder_form.yes'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-1 make-inline">
                                {!! Form::radio('penalty', 2, $penalty[1], array('class' => 'make-inline', 'id' => 'penalty-no', 'disabled' => 'disabled')) !!}
                                {!! Form::label('penalty', Lang::get('legal_folder_form.no'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="penalty-text row hide">
                    <div class="padding-left-right-15">
                        <div class="padding-left-right-15">
                            <div class="form-group float-left width-100-percent">
                                {!! Form::textarea('penalty_text', $penalty_text, array('class' => 'custom-input-textarea width-100-percent', 'disabled' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lawyer-actions form-section">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">4. @lang($p."lawyer_actions")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    for($i = 0; $i < 5; $i++){
                        $lawyer[$i] = false;
                    }
                    if(isset($lawyer_action) and $lawyer_action != null){
                        foreach($lawyer_action as $law_action){
                            $lawyer[$law_action->lawyer_action_id - 1] = true;
                        }
                    }
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 1, $lawyer[0], array('class' => 'float-left', 'disabled' => 'disabled')) !!}
                            {!! Form::label('rights_advise', Lang::get('legal_folder_form.rights_advise'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 2, $lawyer[1], array('class' => 'float-left', 'disabled' => 'disabled')) !!}
                            {!! Form::label('asylum_advise', Lang::get('legal_folder_form.asylum_advise'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 3, $lawyer[2], array('class' => 'float-left', 'disabled' => 'disabled')) !!}
                            {!! Form::label('interview_preparation', Lang::get('legal_folder_form.interview_preparation'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 4, $lawyer[3], array('class' => 'float-left', 'disabled' => 'disabled')) !!}
                            {!! Form::label('appeal', Lang::get('legal_folder_form.appeal'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 5, $lawyer[4], array('class' => 'float-left', 'disabled' => 'disabled')) !!}
                            {!! Form::label('detention_lift', Lang::get('legal_folder_form.detention_lift'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
{!! Form::close() !!}
</div>
