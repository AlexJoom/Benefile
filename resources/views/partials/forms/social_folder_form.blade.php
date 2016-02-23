<div class="social-folder-form">
<?php
    $p = "social_folder_form.";
    if(!isset($social_folder) || $social_folder == null){
        $social_folder = (object) array(
            'comments' => null,
        );
    }
    // format correctly the dates!
    $datesHelper = new \app\Services\DatesHelper();
    if (isset($benefiter) and $benefiter != null){
        if ($benefiter->birth_date != null) {
            $benefiter->birth_date = $datesHelper->getFinelyFormattedStringDateFromDBDate($benefiter->birth_date);
        }
    }
?>
{!! Form::open(array('url' => 'benefiter/'.$benefiter->id.'/social-folder')) !!}
    <div class="personal-family-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. @lang($p."personal_family_info")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
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
                            {!! Form::text('children_names', $benefiter->children_names, array('class' => 'custom-input-text')) !!}
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
                            {!! Form::text('ethnic_group', $benefiter->ethnic_group, array('class' => 'custom-input-text')) !!}
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
    <div class="comments form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. @lang($p."comments")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::textarea('comments', $social_folder->comments, array('class' => 'custom-input-textarea width-100-percent')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="psychosocial-support form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. @lang($p."psychosocial_support")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php
                        for($i = 0; $i < 6; $i++){
                            $psychosocial_statuses[$i] = false;
                        }
                        if(isset($psychosocial_support) and $psychosocial_support != null){
                            foreach($psychosocial_support as $support){
                                $psychosocial_statuses[$support->psychosocial_support_id - 1] = true;
                            }
                        }
                    ?>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 1, $psychosocial_statuses[0], array('class' => 'float-left', 'tabindex' => '1')) !!}
                            {!! Form::label('individual_empowerment', Lang::get('social_folder_form.individual_empowerment'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 2, $psychosocial_statuses[1], array('class' => 'float-left', 'tabindex' => '2')) !!}
                            {!! Form::label('self_esteem', Lang::get('social_folder_form.self_esteem'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 3, $psychosocial_statuses[2], array('class' => 'float-left', 'tabindex' => '3')) !!}
                            {!! Form::label('family_problems', Lang::get('social_folder_form.family_problems'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 4, $psychosocial_statuses[3], array('class' => 'float-left', 'tabindex' => '4')) !!}
                            {!! Form::label('education', Lang::get('social_folder_form.education'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 5, $psychosocial_statuses[4], array('class' => 'float-left', 'tabindex' => '5')) !!}
                            {!! Form::label('legal_issues', Lang::get('social_folder_form.legal_issues'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 6, $psychosocial_statuses[5], array('class' => 'float-left', 'tabindex' => '6')) !!}
                            {!! Form::label('job_search', Lang::get('social_folder_form.job_search'), array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="new-session form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">4. @lang($p."new_session")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group padding-left-right-15 float-left col-md-2">
                            {!! Form::label('doctor_name', 'ΚΑΤΑΧΩΡΗΘΗΚΕ ΑΠΟ:') !!}
                            {!! Form::text('doctor_name', Auth::user()->name.' '.Auth::user()->lastname, array('class' => 'custom-input-text width-80-percent', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group padding-left-right-15 float-left col-md-2">
                            {!! Form::label('session_date', Lang::get('social_folder_form.session_date')) !!}
                            {!! Form::text('session_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        <div class="form-group padding-left-right-15 float-left col-md-3">
                            <div class="width-100-percent">
                                {!! Form::label('psychosocial_theme', Lang::get('social_folder_form.psychosocial_theme')) !!}
                            </div>
                            <select name="psychosocial_theme">
                                <?php
                                    $first = true;
                                ?>
                                @foreach($psychosocialSubjects as $subject)
                                <?php $selected = "";?>
                                @if($first)
                                    <?php $selected = "selected";
                                          $first = false;
                                    ?>
                                @endif
                                <option value="{{ $subject->id }}" {{ $selected }}>{{ $subject->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::label('session_comments', Lang::get('social_folder_form.session_comments')) !!}
                            {!! Form::textarea('session_comments', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section align-text-center">
        {!! Form::submit(Lang::get('social_folder_form.save_social_folder'), array('class' => 'submit-button')) !!}
    </div>
{!! Form::close() !!}
</div>
