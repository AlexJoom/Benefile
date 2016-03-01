<div class="legal-folder-form">
<?php
    $p = "legal_folder_form.";
?>
{!! Form::open(array('url' => 'benefiter/'.$benefiter->id.'/social-folder')) !!}
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
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('legal_folder_status', 1, true, array('class' => 'make-inline')) !!}
                                {!! Form::label('legal_folder_status', Lang::get('legal_folder_form.asylum'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('legal_folder_status', 2, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('legal_folder_status', Lang::get('legal_folder_form.no_legal'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="asylum-request padding-left-right-15">
                        <div class="padding-left-right-15">
                            <div class="form-group float-left width-100-percent">
                                <div class="col-md-3 make-inline">
                                    {!! Form::radio('procedure', 1, true, array('class' => 'make-inline')) !!}
                                    {!! Form::label('procedure', Lang::get('legal_folder_form.procedure_old'), array('class' => 'radio-value')) !!}
                                </div>
                                <div class="col-md-3 make-inline">
                                    {!! Form::radio('procedure', 2, false, array('class' => 'make-inline')) !!}
                                    {!! Form::label('procedure', Lang::get('legal_folder_form.procedure_new'), array('class' => 'radio-value')) !!}
                                </div>
                                <div class="col-md-6 make-inline">
                                    {!! Form::label('request_status', Lang::get('legal_folder_form.request_status')) !!}
                                    <select name="request_status" class="request-status-selection">
                                        <option value="1">α'</option>
                                        <option value="2">β'</option>
                                        <option value="3">μεταγενέστερο</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="padding-left-right-15">
                                <div class="padding-left-right-15">
                                    <div class="form-group padding-left-right-15">
                                        {!! Form::label('request_progress', Lang::get('legal_folder_form.request_progress')) !!}
                                        {!! Form::textarea('request_progress', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="no-legal padding-left-right-15">
                        <div class="padding-left-right-15">
                            <div class="form-group float-left width-100-percent">
                                <div class="col-md-3 make-inline">
                                    {!! Form::radio('action', 1, true, array('class' => 'make-inline')) !!}
                                    {!! Form::label('action', Lang::get('legal_folder_form.action_none'), array('class' => 'radio-value')) !!}
                                </div>
                                <div class="col-md-3 make-inline">
                                    {!! Form::radio('action', 2, false, array('class' => 'make-inline')) !!}
                                    {!! Form::label('action', Lang::get('legal_folder_form.action_refusal'), array('class' => 'radio-value')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="padding-left-right-15">
                                <div class="form-group padding-left-right-15">
                                    <div class="col-md-1 make-inline">
                                        {!! Form::label('result', Lang::get('legal_folder_form.result')) !!}
                                    </div>
                                    <div class="col-md-2 make-inline">
                                        {!! Form::radio('result', 1, true, array('class' => 'make-inline')) !!}
                                        {!! Form::label('result', Lang::get('legal_folder_form.positive'), array('class' => 'radio-value')) !!}
                                    </div>
                                    <div class="col-md-2 make-inline">
                                        {!! Form::radio('result', 2, false, array('class' => 'make-inline')) !!}
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
    <div class="penalties form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. @lang($p."penalties")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-1 make-inline">
                                {!! Form::label('penalty', Lang::get('legal_folder_form.penalty')) !!}
                            </div>
                            <div class="col-md-1 make-inline">
                                {!! Form::radio('penalty', 1, true, array('class' => 'make-inline')) !!}
                                {!! Form::label('penalty', Lang::get('legal_folder_form.yes'), array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-1 make-inline">
                                {!! Form::radio('penalty', 2, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('penalty', Lang::get('legal_folder_form.no'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="padding-left-right-15">
                            <div class="form-group float-left width-100-percent">
                                {!! Form::textarea('penalty_text', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 1, null, array('class' => 'float-left')) !!}
                            {!! Form::label('rights_advise', Lang::get('legal_folder_form.rights_advise'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 2, null, array('class' => 'float-left')) !!}
                            {!! Form::label('asylum_advise', Lang::get('legal_folder_form.asylum_advise'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 3, null, array('class' => 'float-left')) !!}
                            {!! Form::label('interview_preparation', Lang::get('legal_folder_form.interview_preparation'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 4, null, array('class' => 'float-left')) !!}
                            {!! Form::label('appeal', Lang::get('legal_folder_form.appeal'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('lawyer_action[]', 5, null, array('class' => 'float-left')) !!}
                            {!! Form::label('detention_lift', Lang::get('legal_folder_form.detention_lift'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section align-text-center">
        {!! Form::submit(Lang::get('legal_folder_form.save_legal_folder'), array('class' => 'submit-button')) !!}
    </div>
{!! Form::close() !!}
</div>
