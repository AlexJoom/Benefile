<div class="social-folder-form">
{!! Form::open(array('url' => 'new-benefiter/social-folder')) !!}
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
                            {!! Form::text('lastname', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('name', 'ΟΝΟΜΑ') !!}
                            {!! Form::text('name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('fathers_name', 'ΠΑΤΡΩΝΥΜΟ') !!}
                            {!! Form::text('fathers_name', null, array('class' => 'custom-input-text')) !!}
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
                            {!! Form::text('origin_country', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('ethnic_group', 'ΕΘΝΟΤΙΚΗ ΟΜΑΔΑ') !!}
                            {!! Form::text('ethnic_group', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('birthday', 'ΗΜ. ΓΕΝΝΗΣΗΣ') !!}
                            {!! Form::text('birthday', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('telephone', 'ΤΗΛΕΦΩΝΟ') !!}
                            {!! Form::text('telephone', null, array('class' => 'custom-input-text')) !!}
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
                            {!! Form::textarea('comments', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
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
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial-statuses', 1, false, array('class' => 'float-left')) !!}
                            {!! Form::label('individual_empowerment', 'Ενδυνάμωση-Αυτενέργεια ατόμου', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial-statuses', 2, false, array('class' => 'float-left')) !!}
                            {!! Form::label('self_esteem', 'Ενίσχυση αυτοεκτίμησης και αυτοπεποίθησης', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial-statuses', 3, false, array('class' => 'float-left')) !!}
                            {!! Form::label('family_problems', 'Συνεργασία με οικογένεια για την αντιμετώπιση oικογενειακών ή άλλων προβλημάτων', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial-statuses', 4, false, array('class' => 'float-left')) !!}
                            {!! Form::label('education', 'Εκπαίδευση-Κατάρτιση', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial-statuses', 5, false, array('class' => 'float-left')) !!}
                            {!! Form::label('legal_issues', 'Νομικά ζητήματα', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('psychosocial-statuses', 6, false, array('class' => 'float-left')) !!}
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
                            {!! Form::label('session_date', 'ΗΜ. ΣΥΝΕΔΡΙΑΣ') !!}
                            {!! Form::text('session_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        <div class="form-group padding-left-right-15 float-left col-md-3">
                            <div class="width-100-percent">
                                {!! Form::label('psychosocial_theme', 'ΘΕΜΑ') !!}
                            </div>
                            <select name="psychosocial_theme"></select>
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
