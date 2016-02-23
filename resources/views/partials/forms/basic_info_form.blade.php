<div class="basic-info-form">
{!! Form::model($benefiter, array('url' => 'benefiter/'.$benefiter->id.'/basic-info')) !!}

    <div class="personal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">1. Προσωπικά Στοιχεία</h1>
        </div>
        {{-- BENEFITER FOLDER NUMBER --}}
            <div class="row padding-top-20">
                <div class="col-md-12">
                    <div class="row">
                        <div class="padding-left-right-15">
                            <div class="form-group padding-left-right-15 float-left">
                                {!! Form::label('folder_number', 'ΑΡΙΘΜΟΣ ΦΑΚΕΛΟΥ') !!}
                                {!! Form::text('folder_number', null, array('class' => 'custom-input-text text-align-right')) !!}
                            </div>
                        </div>
                    </div>
                </div>
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
                                {!! Form::radio('gender', 1, $male, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender', 'Άνδρας', array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender', 2, $female, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender', 'Γυναίκα', array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('ΗΜΕΡ. ΓΕΝΝΗΣΗΣ') !!}
                            <div class="make-inline">
                                {!! Form::text('birth_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
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
                            {!! Form::text('arrival_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('telephone', 'ΤΗΛ. ΕΠΙΚΟΙΝΩΝΙΑΣ') !!}
                            <?php
                                if($benefiter->telephone == 0){
                                    $benefiter->telephone = "";
                                }
                            ?>
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
                            <?php
                                $marital_status[0] = true;
                                for($i = 1; $i < 5; $i++){
                                    $marital_status[$i] = false;
                                }
                                $marital_status[$benefiter->marital_status_id -1] = true;
                            ?>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 1, $marital_status[0], array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Άγαμος', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 2, $marital_status[1], array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Έγγαμος', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 3, $marital_status[2], array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Διαζευμένος/η', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 4, $marital_status[3], array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Χήρος/α', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-2 make-inline">
                                {!! Form::radio('marital_status', 5, $marital_status[4], array('class' => 'make-inline')) !!}
                                {!! Form::label('marital_status', 'Εν διαστάσει', array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('number_of_children', 'ΑΡΙΘΜΟΣ ΠΑΙΔΙΩΝ') !!}
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
                            {!! Form::label('relatives_residence', 'ΤΟΠΟΣ ΔΙΑΜΟΝΗΣ ΣΥΓΓΕΝΙΚΩΝ ΠΡΟΣΩΠΩΝ') !!}
                            {!! Form::text('relatives_residence', null, array('class' => 'custom-input-text address')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-6">
                            {!! Form::label('children_names', 'ΟΝΟΜΑΤΑ ΤΕΚΝΩΝ') !!}
                            {!! Form::textarea('children_names', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="legal-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">3. Νομικό Καθεστώς</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php
                        for($i = 0; $i < 7; $i++){
                            $legal_status[$i] = false;
                            $legal_status_text[$i] = "";
                            $legal_status_exp_date[$i] = "";
                        }
                        if(isset($legalStatuses) and $legalStatuses != null){
                            foreach($legalStatuses as $status){
                                $id = $status->legal_lookup_id - 1;
                                $legal_status[$id] = true;
                                $legal_status_text[$id] = $status->description;
                                $legal_status_exp_date[$id] = $status->exp_date;
                            }
                        }
                    ?>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 1, $legal_status[0], array('class' => 'float-left', 'tabindex' => '1')) !!}
                            {!! Form::label('deportation', '∆ιοικητική απόφαση απέλασης', array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[0], array('class' => 'custom-input-text make-inline float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[0], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '1')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 2, $legal_status[1], array('class' => 'float-left', 'tabindex' => '2')) !!}
                            {!! Form::label('asylum_application', 'Αρ. δελτίου αιτήσαντος ασύλου', array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[1], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[1], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '2')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 3, $legal_status[2], array('class' => 'float-left', 'tabindex' => '3')) !!}
                            {!! Form::label('refugee', 'Αρ. δελτίου πρόσφυγα', array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[2], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[2], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '3')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 4, $legal_status[3], array('class' => 'float-left', 'tabindex' => '4')) !!}
                            {!! Form::label('residence_permit', 'Βεβ. άδειας διαμονής (χρόνος/λήξη)', array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[3], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[3], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '4')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 5, $legal_status[4], array('class' => 'float-left', 'tabindex' => '5')) !!}
                            {!! Form::label('immigrant_residence_permit', 'Άδεια παραμονής (μετανάστης)', array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[4], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[4], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '5')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 6, $legal_status[5], array('class' => 'float-left', 'tabindex' => '6')) !!}
                            {!! Form::label('european', 'Ευρωπαίος πολίτης', array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[5], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[5], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '6')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group make-inline padding-left-right-15 float-left width-100-percent">
                            {!! Form::radio('legal_status[]', 7, $legal_status[6], array('class' => 'float-left', 'tabindex' => '7')) !!}
                            {!! Form::label('out_of_legal', 'Εκτός νομικού πλαισίου', array('class' => 'float-left')) !!}
                            {!! Form::text('legal_status_text[]', $legal_status_text[6], array('class' => 'custom-input-text float-left')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 hide">
                        <div class="form-group make-inline padding-left-right-15 float-left">
                            {!! Form::label('Ημ. Λήξης') !!}
                            <div class="make-inline">
                                {!! Form::text('legal_status_exp_date[]', $legal_status_exp_date[6], array('class' => 'custom-input-text width-80-percent date-input', 'tabindex' => '7')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="education-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">4. Εκπαίδευση</h1>
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
                                {!! Form::radio('education_status', 1, $education[0], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'Αναλφάβητος', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 2, $education[1], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'Δημοτικό', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 3, $education[2], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'Γυμνάσιο', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 4, $education[3], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'Λύκειο', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 5, $education[4], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'Επαγγελματικό Λύκειο', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 6, $education[5], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'ΤΕΙ', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 7, $education[6], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'ΑΕΙ', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 8, $education[7], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'Μεταπτυχιακός τίτλος', array('class' => 'radio-value')) !!}
                            </div>
                            <div class="col-md-3 make-inline">
                                {!! Form::radio('education_status', 9, $education[8], array('class' => 'make-inline')) !!}
                                {!! Form::label('education_status', 'Διδακτορικός τίτλος', array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="languages-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">5. Γλώσσες Eπικοινωνίας</h1>
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
                        <div class="form-group float-left width-100-percent">
                            <div class="col-md-3 make-inline">
                                <select name="language{{$counter}}" class="language-selection">
                                    @foreach($languages as $language)
                                    <?php $selected = "";?>
                                    @if($benefiter_language->language_id == $language->id)
                                        <?php $selected = "selected"; ?>
                                    @endif
                                    <option value="{{ $language->id }}" {{ $selected }}>{{ $language->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 make-inline">
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
                                    <option value="{{ $language->id }}" {{ $selected }}>{{ $language->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 make-inline">
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
                            {!! Form::checkbox('interpreter', true, $interpreter, array('class' => 'float-left')) !!}
                            {!! Form::label('interpreter', 'Χρήση διερμηνέα', array('class' => 'float-left')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="work-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">6. Εργασία</h1>
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
                            {!! Form::label('working', 'Ναι', array('class' => 'radio-value')) !!}
                        </div>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working', 2, $not_working, array('id' => 'hide_work_legally')) !!}
                            {!! Form::label('working', 'Όχι', array('class' => 'radio-value')) !!}
                        </div>
                    </div>
                </div>
                <div id="working_legally_div" class="row">
                    <div class="padding-left-right-15">
                        <span class="float-left padding-left-right-15">Εργάζεται: </span>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working_legally', 1, $working_legally) !!}
                            {!! Form::label('working_legally', 'Νόμιμα', array('class' => 'radio-value')) !!}
                        </div>
                        <div class="form-group float-left col-md-2">
                            {!! Form::radio('working_legally', 2, $working_illegally) !!}
                            {!! Form::label('working_legally', 'Παράνομα', array('class' => 'radio-value')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="country-abandon-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">7. Λόγος εγκατάλειψης χώρας</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            {!! Form::text('country_abandon_reason', null, array('class' => 'custom-input-text width-100-percent')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="travel-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">8. Ταξίδι</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            {!! Form::label('travel_route', 'Διαδρομή') !!}
                            {!! Form::text('travel_route', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group padding-left-right-15">
                            {!! Form::label('travel_duration', 'Διάρκεια') !!}
                            {!! Form::text('travel_duration', null, array('class' => 'custom-input-text')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="detention-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">9. Διάρκεια Κράτησης</h1>
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
    <div class="detention-info form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">10. Κοινωνικό Ιστορικό</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group padding-left-right-15">
                            {!! Form::textarea('social_history', null, array('class' => 'custom-input-textarea width-100-percent')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section align-text-center">
        {!! Form::submit('Αποθήκευση Βασικών Στοιχείων', array('class' => 'submit-button')) !!}
    </div>
{!! Form::close() !!}
    {{-- BASIC INFO REFERRALS --}}
    @if($benefiter->id == -1)
        <div class="row">
            <div class="col-md-12 referral-info">
                <p>Για την δυνατότητα καταχώρησης παραπομπής, καταχωρήστε και αποθηκεύστε πρώτα τα στοιχεία του οφελούμενου. </p>
            </div>
        </div>
    @else
        {{-- REFERRALS --}}
        <div class="form-section no-bottom-border">
            <div class="underline-header">
                <h1 class="record-section-header padding-left-right-15">11. Παραπομπές</h1>
            </div>
            {{-- OLDER REFERRALS LIST --}}
            <h5 class="text-align-center">ΛΙΣΤΑ ΠΑΡΑΠΟΜΠΩΝ</h5>
            <div class="row">
                <div class="col-md-12">
                    <div id="basic_info_referrals-list" class="row padding-bottom-30">
                        <div class="no-margin pos-relative" id="results-to-activate">
                            <div class="display padding-20">
                                <table id="usersTable-to-activate" class="display" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ΠΑΡΑΠΟΜΠΗ</th>
                                        <th>ΠΕΡΙΓΡΑΦΗ</th>
                                        <th>ΗΜ. ΠΑΡΑΠΟΜΠΗΣ</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ΠΑΡΑΠΟΜΠΗ</th>
                                        <th>ΠΕΡΙΓΡΑΦΗ</th>
                                        <th>ΗΜ. ΠΑΡΑΠΟΜΠΗΣ</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    {{--@foreach($users as $user)--}}
                                        {{--@if($user['activation_status'] == 0 && $user['is_deactivated'] == 0)--}}
                                            {{--<tr>--}}
                                                {{--<td>{{ $user['lastname'] }}</td>--}}
                                                {{--<td>{{ $user['name'] }}</td>--}}
                                                {{--@if($user['user_role_id'] == 2)--}}
                                                    {{--<td>{{$user['role']['role']}} ({{$user['subrole']['subrole']}})</td>--}}
                                                {{--@else--}}
                                                    {{--<td>{{$user['role']['role']}}</td>--}}
                                                {{--@endif--}}
                                                {{--<td>{{substr($user['created_at'], 0,11)}}</td>--}}

                                                {{--<td>--}}
                                                    {{--<form method="post" action="{{action('MainPanel\UsersController@UserStatusUpdate')}}">--}}
                                                        {{--<input type="hidden" name="user_id" value={{$user['id']}}>--}}
                                                        {{--<button class="lighter-green-background">ΕΝΕΡΓΟΠΟΙΗΣΗ</button>--}}
                                                        {{--{{ csrf_field() }}--}}
                                                    {{--</form>--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <div class="make-inline col-md-10">
                                        {!! Form::label('basic_info_referrals', 'ΠΑΡΑΠΟΜΠΗ: ') !!}
                                        {!! Form::select('basic_info_referrals_id[]', $basic_info_referral_array) !!}

                                        {!! Form::text('basic_info_referrals_text[]', null, array('id'=>'basic_info_refList', 'class' => 'custom-input-text display-inline width-50-percent')) !!}

                                        {{-- add --}}
                                        <a class="color-green add-ref float-right" href="javascript:void(0)">
                                            <span class="glyphicon glyphicon-plus-sign make-inline"></span>
                                        </a>
                                        {{-- remove --}}
                                        <a class="color-red remove-ref hide-element float-right" href="javascript:void(0)">
                                            <span class="glyphicon glyphicon-minus-sign make-inline"></span>
                                        </a>
                                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-right col-md-2">
                                            {!! Form::text('basic_info_referrals_date[]', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-section align-text-center">
                    {!! Form::submit('Αποθήκευση Παραπομπών', array('class' => 'submit-button')) !!}
                </div>
            {!! Form::close() !!}
        </div>
    @endif
</div>
