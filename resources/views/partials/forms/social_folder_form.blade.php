<div class="social-folder-form">
<?php
    $p = "social_folder_form.";
    $social_folder_is_null = false;
    if(!isset($social_folder) || $social_folder == null){
        $social_folder_is_null = true;
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
    <div class="comments form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. @lang($p."comments")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            <!-- ACCESS LEVEL -->
                            @if (Auth::user()->user_role_id == 4 || Auth::user()->user_role_id == 1)
                                {!! Form::textarea('comments', $social_folder->comments, array('class' => 'custom-input-textarea width-100-percent')) !!}
                            @else
                            {!! Form::textarea('comments', $social_folder->comments, array('class' => 'custom-input-textarea width-100-percent', 'disabled' => 'disabled', 'style' => 'color: #b8bcbb;')) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section align-text-center no-bottom-border">
        <!-- ACCESS LEVEL -->
        @if (Auth::user()->user_role_id == 4 || Auth::user()->user_role_id == 1)
            {!! Form::submit(Lang::get('social_folder_form.save_social_folder'), array('class' => 'submit-button')) !!}
        @else
            {!! Form::submit(Lang::get('social_folder_form.save_social_folder'), array('class' => 'submit-button', 'disabled' => 'disabled')) !!}
        @endif
    </div>
{!! Form::close() !!}

@if(!$social_folder_is_null)
    <div class="psychosocial-support form-section">
        <div class="underline-header row">
            <h1 id="psychosocial-history-title" class="record-section-header padding-left-right-15 float-left">3. @lang($p."psychosocial_support_history")</h1>
            <!-- ACCESS LEVEL -->
            @if (Auth::user()->user_role_id == 5 || Auth::user()->user_role_id == 1)
                <button id="add-new-session" class="float-right simple-button">@lang($p."add_new_session")</button>
            @endif
        </div>
        <div class="new-session dynamic-form-section">
            <h1 class="record-section-header padding-left-right-15">@lang($p."new_session")</h1>
            {!! Form::open(array('url' => 'benefiter/'.$benefiter->id.'/session-save')) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group padding-left-right-15 float-left col-md-2">
                                {!! Form::label('psychologist_name', Lang::get('social_folder_form.created_by')) !!}
                                {!! Form::text('psychologist_name', Auth::user()->name.' '.Auth::user()->lastname, array('class' => 'custom-input-text width-100-percent', 'disabled' => 'disabled')) !!}
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
                                    <?php
                                        $selected = "";
                                        if(!isset($session_theme)){
                                            if($first) {
                                                $selected = "selected";
                                                $first = false;
                                            }
                                        } else {
                                            if($session_theme == $subject->id) {
                                                $selected = "selected";
                                            }
                                        }
                                    ?>
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
                <div class="align-text-center">
                    {!! Form::submit(Lang::get('social_folder_form.save_session'), array('class' => 'submit-button save-session')) !!}
                </div>
            </div>
           {!! Form::close() !!}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="div-table-titles row">
                    <div class="col-md-12">
                        <div class="col-sm-2"><p>@lang($p."date")</p></div>
                        <div class="col-sm-2"><p>@lang($p."subject")</p></div>
                        <div class="col-sm-4"><p>@lang($p."notes")</p></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(!isset($benefiter_sessions) or $benefiter_sessions == null or $benefiter_sessions->count() == 0)
                <div class="social-info">
                    <p>@lang($p."sessions_not_found")</p>
                </div>
                @else
                @foreach($benefiter_sessions as $benefiter_session)
                <div class="row div-table-row">
                    <div class="col-md-12">
                        <div class="col-sm-2 text-align-center">{{ $datesHelper->getFinelyFormattedStringDateFromDBDate($benefiter_session->session_date) }}</div>
                        <div class="col-sm-2 text-align-center">{{ $psychosocialSubjects[$benefiter_session->psychosocial_theme_id - 1]->description }}</div>
                        <!-- ACCESS LEVEL -->
                        @if(Auth::user()->user_role_id == 5 || Auth::user()->user_role_id == 1)
                            <div class="col-sm-4 text-align-center">{{ $benefiter_session->session_comments }}</div>
                        @else
                            <div class="col-sm-4 text-align-center">----------------</div>
                        @endif
                        <!-- ACCESS LEVEL END -->
                        <div class="col-sm-2">@if(\Auth::user()->user_role_id == 5 || \Auth::user()->user_role_id == 1)<button class="simple-button width-100-percent edit-session">@lang($p."edit")</button>@endif</div>
                        <div class="col-sm-2">@if(\Auth::user()->user_role_id == 5 || \Auth::user()->user_role_id == 1)<button class="simple-button width-100-percent delete-session" name="{{ $benefiter_session->id }}">@lang($p."delete")</button>@endif</div>
                    </div>
                </div>
                <div class="edit-session-div dynamic-form-section">
                    <h1 class="record-section-header padding-left-right-15">@lang($p."edit_session")</h1>
                    {!! Form::open(array('url' => 'benefiter/'.$benefiter->id.'/session-edit/'.$benefiter_session->id)) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group padding-left-right-15 float-left col-md-2">
                                        {!! Form::label('session_date', Lang::get('social_folder_form.session_date')) !!}
                                        {!! Form::text('session_date', $datesHelper->getFinelyFormattedStringDateFromDBDate($benefiter_session->session_date), array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                                    </div>
                                    <div class="form-group padding-left-right-15 float-left col-md-2">
                                        <div class="width-100-percent">
                                            {!! Form::label('psychosocial_theme', Lang::get('social_folder_form.psychosocial_theme')) !!}
                                        </div>
                                        <select name="psychosocial_theme">
                                            @foreach($psychosocialSubjects as $subject)
                                            <?php
                                                $selected = "";
                                                if($benefiter_session->psychosocial_theme_id == $subject->id) {
                                                    $selected = "selected";
                                                }
                                            ?>
                                            <option value="{{ $subject->id }}" {{ $selected }}>{{ $subject->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                                        {!! Form::label('session_comments', Lang::get('social_folder_form.session_comments')) !!}
                                        {!! Form::textarea('session_comments', $benefiter_session->session_comments, array('class' => 'custom-input-textarea width-100-percent')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="align-text-center">
                            {!! Form::submit(Lang::get('social_folder_form.save_edited_session'), array('class' => 'submit-button save-session')) !!}
                        </div>
                    </div>
                   {!! Form::close() !!}
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
@else
    <div class="form-section no-bottom-border">
        <div class="col-md-12 social-info">
            <p>@lang($p."psychosocial_support_info")</p>
        </div>
    </div>
@endif
</div>
<!--delete session confirmation modal-->
<div class="modal fade" id="delete-session-modal" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="delete-session-form" action="" method="get">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" class="delete-session-path" name="path" value="{{ url("benefiter/".$benefiter->id."/session-delete/") }}">
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
