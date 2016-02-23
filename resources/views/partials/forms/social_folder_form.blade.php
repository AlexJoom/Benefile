<div class="social-folder-form">
<?php
    if(!isset($social_folder) || $social_folder == null){
        $social_folder = (object) array(
            'ethnic_group' => null,
            'comments' => null,
        );
    }
?>
{!! Form::open(array('url' => 'benefiter/'.$benefiter->id.'/social-folder')) !!}
    <div class="personal-family-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. Προσωπικά Στοιχεία Ατόμου-Οικογένειας</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('lastname', 'ΕΠΩΝΥΜΟ') !!}
                            {!! Form::text('lastname', $benefiter->lastname, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('name', 'ΟΝΟΜΑ') !!}
                            {!! Form::text('name', $benefiter->name, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('fathers_name', 'ΠΑΤΡΩΝΥΜΟ') !!}
                            {!! Form::text('fathers_name', $benefiter->fathers_name, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('children_names', 'ΟΝΟΜΑΤΑ ΤΕΚΝΩΝ') !!}
                            {!! Form::text('children_names', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('origin_country', 'ΧΩΡΑ ΚΑΤΑΓΩΓΗΣ') !!}
                            {!! Form::text('origin_country', $benefiter->origin_country, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('ethnic_group', 'ΕΘΝΟΤΙΚΗ ΟΜΑΔΑ') !!}
                            {!! Form::text('ethnic_group', $social_folder->ethnic_group, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('birthday', 'ΗΜ. ΓΕΝΝΗΣΗΣ') !!}
                            {!! Form::text('birthday', $benefiter->birth_date, array('class' => 'custom-input-text width-80-percent date-input', 'disabled' => 'disabled')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date hide"></span></a>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('telephone', 'ΤΗΛΕΦΩΝΟ') !!}
                            {!! Form::text('telephone', $benefiter->telephone, array('class' => 'custom-input-text', 'disabled' => 'disabled')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="comments form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. Σχόλια</h1>
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
            <h1 class="record-section-header padding-left-right-15">3. Ψυχοκοινωνική Στήριξη</h1>
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
                            {!! Form::label('individual_empowerment', 'Ενδυνάμωση-Αυτενέργεια ατόμου', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 2, $psychosocial_statuses[1], array('class' => 'float-left', 'tabindex' => '2')) !!}
                            {!! Form::label('self_esteem', 'Ενίσχυση αυτοεκτίμησης και αυτοπεποίθησης', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 3, $psychosocial_statuses[2], array('class' => 'float-left', 'tabindex' => '3')) !!}
                            {!! Form::label('family_problems', 'Συνεργασία με οικογένεια για την αντιμετώπιση oικογενειακών ή άλλων προβλημάτων', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 4, $psychosocial_statuses[3], array('class' => 'float-left', 'tabindex' => '4')) !!}
                            {!! Form::label('education', 'Εκπαίδευση-Κατάρτιση', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 5, $psychosocial_statuses[4], array('class' => 'float-left', 'tabindex' => '5')) !!}
                            {!! Form::label('legal_issues', 'Νομικά ζητήματα', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial_statuses[]', 6, $psychosocial_statuses[5], array('class' => 'float-left', 'tabindex' => '6')) !!}
                            {!! Form::label('job_search', 'Εκμάθηση τεχνικών αναζήτησης εργασίας', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="new-session form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">4. Νέα Συνεδρία</h1>
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
                            {!! Form::label('session_date', 'ΗΜ. ΣΥΝΕΔΡΙΑΣ') !!}
                            {!! Form::text('session_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        <div class="form-group padding-left-right-15 float-left col-md-3">
                            <div class="width-100-percent">
                                {!! Form::label('psychosocial_theme', 'ΘΕΜΑ') !!}
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
                            {!! Form::label('session_comments', 'ΠΑΡΑΤΗΡΗΣΕΙΣ') !!}
                            {!! Form::textarea('session_comments', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section align-text-center">
        {!! Form::submit('Αποθήκευση Κοινωνικού Φακέλου', array('class' => 'submit-button')) !!}
    </div>
{!! Form::close() !!}
</div>
