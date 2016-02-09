<div class="basic-info-form">
{{--{!! Form::model($user, array('url' => 'PUT_STH_HERE!!!')) !!}--}}
{!! Form::open(array('url' => 'PUT_STH_HERE!!!')) !!}
    <div class="personal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. Προσωπικά Στοιχεία</h1>
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
                            {!! Form::label('gender', 'ΦΥΛΟ') !!}
                            <div class="make-inline">
                                {!! Form::radio('gender', 1, true, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender', 'Άνδρας', array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender', 2, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender', 'Γυναίκα', array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('ΗΜΕΡ. ΓΕΝΝΗΣΗΣ') !!}
                            <div class="make-inline">
                                {!! Form::text('birth_day', null, array('class' => 'custom-input-text date-text-input')) !!}<span class="bold-slash">/</span>
                                {!! Form::text('birth_month', null, array('class' => 'custom-input-text date-text-input')) !!}<span class="bold-slash">/</span>
                                {!! Form::text('birth_year', null, array('class' => 'custom-input-text date-text-input')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('fathers_name', 'ΠΑΤΡΩΝΥΜΟ') !!}
                            {!! Form::text('fathers_name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('mothers_name', 'ΜΗΤΡΩΝΥΜΟ') !!}
                            {!! Form::text('mothers_name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('nationality_country', 'ΧΩΡΑ ΕΘΝΙΚΟΤΗΤΑΣ') !!}
                            {!! Form::text('nationality_country', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('origin_country', 'ΧΩΡΑ ΚΑΤΑΓΩΓΗΣ') !!}
                            {!! Form::text('origin_country', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('arrival_date', 'ΗΜΕΡ. ΑΦΙΞΗΣ') !!}
                            {!! Form::text('arrival_date', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('telephone', 'ΤΗΛ. ΕΠΙΚΟΙΝΩΝΙΑΣ') !!}
                            {!! Form::text('telephone', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-6">
                            {!! Form::label('address', 'Δ/ΝΣΗ ΚΑΤΟΙΚΙΑΣ') !!}
                            {!! Form::text('address', null, array('class' => 'custom-input-text address')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="family-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">2. Οικογενειακή Κατάσταση</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 1, true, array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Άγαμος', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 2, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Έγγαμος', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 3, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Διαζευμένος/η', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 4, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Χήρος/α', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 5, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Εν διαστάσει', array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('number_of_children', 'ΑΡΙΘΜΟΣ ΠΑΙΔΙΩΝ') !!}
                            {!! Form::text('number_of_children', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-6">
                            {!! Form::label('relatives_residence', 'ΤΟΠΟΣ ΔΙΑΜΟΝΗΣ ΣΥΓΓΕΝΙΚΩΝ ΠΡΟΣΩΠΩΝ') !!}
                            {!! Form::text('relatives_residence', null, array('class' => 'custom-input-text address')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="legal-info form-section">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. Νομικό Καθεστώς</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('legal_status', 1, false, array('class' => 'float-left')) !!}
                            {!! Form::label('deportation', '∆ιοικητική απόφαση απέλασης', array('class' => 'float-left')) !!}
                            {!! Form::text('deportation', null, array('class' => 'custom-input-text make-inline float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('deportation_day', null, array('class' => 'custom-input-text date-text-input')) !!}<span class="bold-slash">/</span>
                                {!! Form::text('deportation_month', null, array('class' => 'custom-input-text date-text-input')) !!}<span class="bold-slash">/</span>
                                {!! Form::text('deportation_year', null, array('class' => 'custom-input-text date-text-input')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('legal_status', 2, false, array('class' => 'float-left')) !!}
                            {!! Form::label('asylum_application', 'Αρ. δελτίου αιτήσαντος ασύλου', array('class' => 'float-left')) !!}
                            {!! Form::text('asylum_application', null, array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('asylum_day', null, array('class' => 'custom-input-text date-text-input')) !!}<span class="bold-slash">/</span>
                                {!! Form::text('asylum_month', null, array('class' => 'custom-input-text date-text-input')) !!}<span class="bold-slash">/</span>
                                {!! Form::text('asylum_year', null, array('class' => 'custom-input-text date-text-input')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::checkbox('legal_status', 3, false, array('class' => 'float-left')) !!}
                            {!! Form::label('refugee', 'Αρ. δελτίου πρόσφυγα', array('class' => 'float-left')) !!}
                            {!! Form::text('refugee', null, array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('refugee_day', null, array('class' => 'custom-input-text date-text-input')) !!}<span class="bold-slash">/</span>
                                {!! Form::text('refugee_month', null, array('class' => 'custom-input-text date-text-input')) !!}<span class="bold-slash">/</span>
                                {!! Form::text('refugee_year', null, array('class' => 'custom-input-text date-text-input')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
</div>
