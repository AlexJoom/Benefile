<?php
    $p = 'reports.';
?>

@extends('layouts.mainPanel')

@section('panel-title')
    @lang('layouts/mainPanel.reports')
@stop

@section('panel-headLinks')
    <link href="{{ asset('/plugins/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/records/record_form.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/search/search.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/reports/reports.css') }}" rel="stylesheet" type="text/css">
@stop

@section('main-window-content')
    {{-- report for users numbers divided by their roles --}}
    <div class="users-report form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">@lang($p."users")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="doctors" class="col-md-3">
                    <img class="make-inline width-85px" src="{{ asset('/img/benefile_3_doctors.jpg') }}" />
                    <div class="make-inline">
                        <p class="users-title">@lang($p."doctors")</p>
                        <p class="users-counter">{{ $users_roles_count['doctors'] }}</p>
                    </div>
                </div>
                <div id="legals" class="col-md-3">
                    <img class="make-inline width-85px" src="{{ asset('/img/benefile_3_legals.jpg') }}" />
                    <div class="make-inline">
                        <p class="users-title">@lang($p."legals")</p>
                        <p class="users-counter">{{ $users_roles_count['legals'] }}</p>
                    </div>
                </div>
                <div id="psychologists" class="col-md-3">
                    <img class="make-inline width-85px" src="{{ asset('/img/benefile_3_psychologists.jpg') }}" />
                    <div class="make-inline">
                        <p class="users-title">@lang($p."psychologists")</p>
                        <p class="users-counter">{{ $users_roles_count['psychologists'] }}</p>
                    </div>
                </div>
                <div id="socials" class="col-md-3">
                    <img class="make-inline width-85px" src="{{ asset('/img/benefile_3_socials.jpg') }}" />
                    <div class="make-inline">
                        <p class="users-title">@lang($p."socials")</p>
                        <p class="users-counter">{{ $users_roles_count['socials'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="benefiters-report form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">@lang($p."benefiters")</h1>
        </div>

        {{-- REPORT: Benefiters VS gerder --}}
        <div id="benefiters_vs_gerder" class="row padding-30 row-eq-height display-table ">
            <div class="col-md-10 col-equal-height">
                {{-- male icons --}}
                @for($i=0 ; $i< $report_benefiters_vs_gender['male_percentage'] ; $i++)
                    <icon class="glyphicon glyphicon-user gender-icon male-color"></icon>
                @endfor
                {{-- female icons --}}
                @for($i=0 ; $i< $report_benefiters_vs_gender['female_percentage'] ; $i++)
                    <icon class="glyphicon glyphicon-user gender-icon female-color"></icon>
                @endfor
                {{-- others icons --}}
                @for($i=0 ; $i< $report_benefiters_vs_gender['other_percentage'] ; $i++)
                    <icon class="glyphicon glyphicon-user gender-icon other-color"></icon>
                @endfor

            </div>

            <div class="col-md-2 col-equal-height">
                {{-- male --}}
                <div class=" male-color padding-bottom-30">
                    <div class="gender-number">{{ $report_benefiters_vs_gender['male'] }}</div>

                    <div class="gender-text">@lang($p.'male')</div>
                </div>
                {{-- female --}}
                <div class=" female-color padding-bottom-30">
                    <div class="gender-number">{{ $report_benefiters_vs_gender['female'] }}</div>

                    <div class="gender-text">@lang($p.'female')</div>
                </div>
                {{-- other --}}
                <div class=" other-color">
                    <div class="gender-number">{{ $report_benefiters_vs_gender['other'] }}</div>

                    <div class="gender-text">@lang($p.'other')</div>
                </div>

            </div>
        </div>

        <hr>
        <div class="row">
            {{-- Benefiters marital statuses --}}
            <h4>@lang($p.'h3-marital-status')</h4>
                <div id="maritalStatusReport" class="col-md-12">
            </div>
            {{-- Benefiters marital statuses end --}}
        </div>
        <hr>
        <div class="row">
            {{-- Medical visits location --}}
            <!-- <div class="col&#45;md&#45;6"> -->
            <h4>@lang($p.'h3-medical-visits-location')</h4>
                <div id="medicalStatusReport" class="col-md-12">
            </div>
            <!-- </div> -->
            {{-- Medical visits location end --}}
        </div>
        <hr>
        {{-- Benefiters work titles --}}
        <div class="row">
            <div class="col-md-12">
                <div id="benefiters-work-title" class="col-md-12">
                    <h4>@lang($p.'h3-work-title')</h4>
                    <canvas id="benefiters-work-title-canvas" height="300" width="1000"></canvas>
                </div>
            </div>
        </div>
        {{-- Benefiters work titles end --}}
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div id="benefiters-per-medical-visits" class="col-md-12">
                    <h4>@lang($p.'h3-medical-visits')</h4>
                    <canvas id="benefiters-per-medical-visits-canvas" height="300" width="1000"></canvas>
                </div>
            </div>
        </div>
        {{-- Benefiters age report end --}}
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div id="benefiters-age-report" class="col-md-12">
                    <h4>@lang($p.'h3-age-report')</h4>
                    <div id="ageReport" class="col-md-12">
                    </div>
                </div>
            </div>
        </div>
        {{-- Benefiters legal statuses --}}
        <hr>
        <div class="row">
            <div class="col-md-12">
                    <h4>@lang($p.'h3-legal-status')</h4>
                    <!-- <canvas id="legalStatusReport" height="300" width="1000"></canvas> -->
                    <div id="legalStatusReport"></div>
            </div>
        </div>
        {{-- Benefiters registration numbers per month --}}
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4>@lang($p.'h3-registration-status')</h4>
                    <canvas id="registrationStatusReport" height="300" width="1000"></canvas>
                </div>
            </div>
        </div>

        {{-- REPORT: Benefiters vs education --}}
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'report-education')</h1>
                </div>
                <div id="benefiter_vs_education"></div>
            </div>
        </div>
    </div>
    <div class="benefiters-report form-section">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">@lang($p."search")</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
            {!! Form::open(array('url' => 'reports-search-results', 'id' => 'search-form', 'method' => 'get')) !!}
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('marital_status_id', Lang::get('reports.marital_status')) !!}
                            <div>
                                <select name="marital_status_id" id="marital-status-id" class="width-100-percent">
                                    <option value=0></option>
                                    <?php
                                        if(!empty($marital_statuses)){
                                            foreach($marital_statuses as $marital_status){
                                                echo "<option value=" . $marital_status->id . ">" . $marital_status->marital_status_title . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('age', Lang::get('reports.age')) !!}
                            {!! Form::text('age', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                            {!! Form::label('legal_status_id', Lang::get('reports.legal_status')) !!}
                            <div>
                                <select name="legal_status_id" id="legal-status-id" class="width-100-percent">
                                    <option value=0></option>
                                    <?php
                                        if(!empty($legal_statuses)){
                                            foreach($legal_statuses as $legal_status){
                                                echo "<option value=" . $legal_status->id . ">" . $legal_status->description . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                            {!! Form::label('education_id', Lang::get('reports.education')) !!}
                            <div>
                                <select name="education_id" id="education-id" class="width-100-percent">
                                    <option value=0></option>
                                    <?php
                                        if(!empty($education_titles)){
                                            foreach($education_titles as $education_title){
                                                echo "<option value=" . $education_title->id . ">" . $education_title->education_title . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                            {!! Form::label('gender_id', Lang::get('reports.gender')) !!}
                            <div>
                                {!! Form::radio('gender_id', 1, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender_id', Lang::get('reports.male'), array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender_id', 2, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender_id', Lang::get('reports.female'), array('class' => 'radio-value')) !!}
                                {!! Form::radio('gender_id', 3, false, array('class' => 'make-inline')) !!}
                                {!! Form::label('gender_id', Lang::get('reports.other'), array('class' => 'radio-value')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('work_title_id', Lang::get('reports.work')) !!}
                            <div>
                                <select name="work_title_id" id="work-title-id" class="width-100-percent">
                                    <option value=0></option>
                                    <?php
                                        if(!empty($work_titles)){
                                            foreach($work_titles as $work_title){
                                                if($work_title->work_title == ""){
                                                    $work_title->work_title = "-";
                                                }
                                                echo "<option value=" . $work_title->id . ">" . $work_title->work_title . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('drug', Lang::get('reports.drug')) !!}
                            {!! Form::text('drug', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                            {!! Form::label('incident_type_id', Lang::get('reports.incident_type')) !!}
                            <div>
                                <select name="incident_type_id" id="incident-type-id" class="width-100-percent">
                                    <option value=0></option>
                                    <?php
                                        if(!empty($medical_incident_types)){
                                            foreach($medical_incident_types as $medical_incident_type){
                                                echo "<option value=" . $medical_incident_type->id . ">" . $medical_incident_type->description . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-3">
                            {!! Form::label('location_id', Lang::get('reports.location')) !!}
                            <div>
                                <select name="location_id" id="location-id" class="width-100-percent">
                                    <option value=0></option>
                                    <?php
                                        if(!empty($medical_locations)){
                                            foreach($medical_locations as $location){
                                                echo "<option value=" . $location->id . ">" . $location->description . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('doctor_name', Lang::get('reports.doctor_name')) !!}
                            {!! Form::text('doctor_name', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label('incidents_number', Lang::get('reports.incidents_number')) !!}
                            {!! Form::text('incidents_number', null, array('class' => 'custom-input-text')) !!}
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-4">
                            {!! Form::label('examination_results_id', Lang::get('reports.examination_results')) !!}
                            <div>
                                <select name="examination_results_id" id="examination-results-id" class="width-100-percent">
                                    <option value=0></option>
                                    <?php
                                        if(!empty($medical_examination_results)){
                                            foreach($medical_examination_results as $medical_examination_result){
                                                echo "<option value=" . $medical_examination_result->id . ">" . $medical_examination_result->description . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label(Lang::get('reports.insertion_date')) !!}
                            <div>
                                {!! Form::text('insertion_date', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="padding-left-right-15">
                            {!! Form::label(Lang::get('reports.incident_dates_range')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding-left-right-15">
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label(Lang::get('reports.from')) !!}
                            <div>
                                {!! Form::text('incident_from', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                        <div class="form-group make-inline padding-left-right-15 margin-right-30 float-left col-md-2">
                            {!! Form::label(Lang::get('reports.to')) !!}
                            <div>
                                {!! Form::text('incident_to', null, array('class' => 'custom-input-text width-80-percent date-input')) !!}<a href="javascript:void(0)"><span class="glyphicon glyphicon-remove color-red clear-date"></span></a>
                            </div>
                        </div>
                        {!! Form::submit(Lang::get('reports.search'), array('class' => 'simple-button', 'id' => 'search-btn')) !!}
                    </div>
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('panel-scripts')
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/amcharts/amcharts.js') }}"></script>
    <script src="{{ asset('js/amcharts/pie.js') }}"></script>
    <script src="{{ asset('js/amcharts/themes/light.js') }}"></script>
    <script src="{{ asset('js/reports/reports.js') }}"></script>
    <script src="{{ asset('js/reports/reports-search.js') }}"></script>
    <script src="{{ asset('js/canvasjs.min.js') }}"></script>
    <script src="{{ asset('/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/records/custom_datepicker.js') }}"></script>
    <script src="{{asset('js/forms.js')}}"></script>
    {{-- Benefiter counter status graph --}}
	<script>
        /* Make charts responsive. */
        Chart.defaults.global.responsive = true;

		(function() {
			 var ctx = document.getElementById("registrationStatusReport").getContext("2d");
			 var chart = {
             labels: [ @foreach ($benefiters_count as $count) {!! json_encode($count->created_at) !!}, @endforeach ],
				datasets: [
					{
					label: "My Data",
                    fillColor: "rgba(220,220,220,0.5)",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [ @foreach ($benefiters_count as $count) {!! json_encode($count->idcounter) !!}, @endforeach ],
					}
				]
			};
			var myLineChart = new Chart(ctx).Bar(chart);
            /*
			 * bezierCurve: false
			 * });
             */
		})();
	</script>
    <script>
    {{-- Age report status graph --}}
    $(document).ready(function(){
        var chart = AmCharts.makeChart("ageReport", {
            "titles":[{'text':'','size':22}],
            "type": "pie",
            "startDuration": 0,
            "theme": "light",
            "addClassNames": true,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false

            },
            "innerRadius": "30%",
            "defs": {
                "filter": [{
                    "id": "shadow",
                    "width": "200%",
                    "height": "200%",
                    "feOffset": {
                        "result": "offOut",
                        "in": "SourceAlpha",
                        "dx": 0,
                        "dy": 0
                    },
                    "feGaussianBlur": {
                        "result": "blurOut",
                        "in": "offOut",
                        "stdDeviation": 5
                    },
                    "feBlend": {
                        "in": "SourceGraphic",
                        "in2": "blurOut",
                        "mode": "normal"
                    }
                }]
            },
            "dataProvider": [{
            @foreach ($benefiters_age as $age)
                "benefiters": {!! json_encode($age->ageInYears) !!} + ' - ' + {!! json_encode($age->ageInYears + 9) !!},
                "counter": {!! json_encode($age->counter) !!}
            }, {
            @endforeach
            }],
            "valueField": "counter",
            "titleField": "benefiters",
            "export": {
                "enabled": true
            }
        });


    chart.addListener("init", handleInit);

    chart.addListener("rollOverSlice", function(e) {
        handleRollOver(e);
    });

    function handleInit(){
        chart.legend.addListener("rollOverItem", handleRollOver);
    }

    function handleRollOver(e){
        var wedge = e.dataItem.wedge.node;
        wedge.parentNode.appendChild(wedge);
    }
    });
    </script>
    <script>
    {{-- Marital report status graph --}}
    $(document).ready(function(){
        var chart = AmCharts.makeChart("maritalStatusReport", {
            "titles":[{'text':'','size':22}],
            "type": "pie",
            "startDuration": 0,
            "theme": "light",
            "addClassNames": true,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false

            },
            "innerRadius": "30%",
            "defs": {
                "filter": [{
                    "id": "shadow",
                    "width": "200%",
                    "height": "200%",
                    "feOffset": {
                        "result": "offOut",
                        "in": "SourceAlpha",
                        "dx": 0,
                        "dy": 0
                    },
                    "feGaussianBlur": {
                        "result": "blurOut",
                        "in": "offOut",
                        "stdDeviation": 5
                    },
                    "feBlend": {
                        "in": "SourceGraphic",
                        "in2": "blurOut",
                        "mode": "normal"
                    }
                }]
            },
            "dataProvider": [{
            @foreach ($benefitersMaritalStatuses as $maritalStatus)
                "benefiters": {!! json_encode($maritalStatus->marital_status_title) !!},
                "counter": {!! json_encode($maritalStatus->marital_counter) !!}
            }, {
            @endforeach
            }],
            "valueField": "counter",
            "titleField": "benefiters",
            "export": {
                "enabled": true
            }
        });


    chart.addListener("init", handleInit);

    chart.addListener("rollOverSlice", function(e) {
        handleRollOver(e);
    });

    function handleInit(){
        chart.legend.addListener("rollOverItem", handleRollOver);
    }

    function handleRollOver(e){
        var wedge = e.dataItem.wedge.node;
        wedge.parentNode.appendChild(wedge);
    }
    });
    </script>
    <script>
    {{-- Legal status graph --}}
    $(document).ready(function(){
        var chart = AmCharts.makeChart("legalStatusReport", {
            "titles":[{'text':'','size':22}],
            "type": "pie",
            "startDuration": 0,
            "theme": "light",
            "addClassNames": true,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false

            },
            "innerRadius": "30%",
            "defs": {
                "filter": [{
                    "id": "shadow",
                    "width": "200%",
                    "height": "200%",
                    "feOffset": {
                        "result": "offOut",
                        "in": "SourceAlpha",
                        "dx": 0,
                        "dy": 0
                    },
                    "feGaussianBlur": {
                        "result": "blurOut",
                        "in": "offOut",
                        "stdDeviation": 5
                    },
                    "feBlend": {
                        "in": "SourceGraphic",
                        "in2": "blurOut",
                        "mode": "normal"
                    }
                }]
            },
            "dataProvider": [{
            @foreach ($benefiters_legal_statuses as $legalStatus)
                "benefiters": {!! json_encode($legalStatus->description) !!},
                "litres": {!! json_encode($legalStatus->legal_counter) !!}
            }, {
            @endforeach
            }],
            "valueField": "litres",
            "titleField": "benefiters",
            "export": {
                "enabled": true
            }
        });


    chart.addListener("init", handleInit);

    chart.addListener("rollOverSlice", function(e) {
        handleRollOver(e);
    });

    function handleInit(){
        chart.legend.addListener("rollOverItem", handleRollOver);
    }

    function handleRollOver(e){
        var wedge = e.dataItem.wedge.node;
        wedge.parentNode.appendChild(wedge);
    }
    });
    </script>
    <script>
    {{-- Medical report status graph --}}
    $(document).ready(function(){
        var chart = AmCharts.makeChart("medicalStatusReport", {
            "titles":[{'text':'','size':22}],
            "type": "pie",
            "startDuration": 0,
            "theme": "light",
            "addClassNames": true,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false

            },
            "innerRadius": "30%",
            "defs": {
                "filter": [{
                    "id": "shadow",
                    "width": "200%",
                    "height": "200%",
                    "feOffset": {
                        "result": "offOut",
                        "in": "SourceAlpha",
                        "dx": 0,
                        "dy": 0
                    },
                    "feGaussianBlur": {
                        "result": "blurOut",
                        "in": "offOut",
                        "stdDeviation": 5
                    },
                    "feBlend": {
                        "in": "SourceGraphic",
                        "in2": "blurOut",
                        "mode": "normal"
                    }
                }]
            },
            "dataProvider": [{
            @foreach ($medical_visits_location as $medicalVisit)
                "benefiters": {!! json_encode($medicalVisit->location) !!},
                "counter": {!! json_encode($medicalVisit->counter) !!}
            }, {
            @endforeach
            }],
            "valueField": "counter",
            "titleField": "benefiters",
            "export": {
                "enabled": true
            }
        });


    chart.addListener("init", handleInit);

    chart.addListener("rollOverSlice", function(e) {
        handleRollOver(e);
    });

    function handleInit(){
        chart.legend.addListener("rollOverItem", handleRollOver);
    }

    function handleRollOver(e){
        var wedge = e.dataItem.wedge.node;
        wedge.parentNode.appendChild(wedge);
    }
    });
    </script>
    <script>
        (function(){
            var $benefiters_work_title_canvas = $("#benefiters-work-title-canvas").get(0).getContext("2d");
            var $data = {
                @if(!empty($benefiters_work_title))
                labels: [ @foreach($benefiters_work_title as $key => $value) @if($key != "") "{!! $key !!}", @else "-", @endif @endforeach ],
                datasets: [
                    {
                        label: "",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: [ @foreach($benefiters_work_title as $key => $value) {!! $value !!}, @endforeach ]
                    }
                ]
                @else
                labels: [ "" ],
                datasets: [
                    {
                        label: "-",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: [ 0 ]
                    }
                ]
                @endif
            };
            new Chart($benefiters_work_title_canvas).Bar($data, {});
        })();
    </script>
    <script>
        (function(){
            var $benefiters_per_medical_visits_canvas = $("#benefiters-per-medical-visits-canvas").get(0).getContext("2d");
            var $data = {
                @if(!empty($benefiters_medical_visits))
                labels: [ @foreach($benefiters_medical_visits as $single_benefiters_medical_visits) "{!! $single_benefiters_medical_visits->visits_counter !!}@if($single_benefiters_medical_visits->visits_counter == "1") @lang($p."visit")", @else @lang($p."visits")", @endif @endforeach ],
                datasets: [
                    {
                        label: "",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: [ @foreach($benefiters_medical_visits as $single_benefiters_medical_visits) {!! $single_benefiters_medical_visits->benefiters_counter !!}, @endforeach ]
                    }
                ]
                @else
                labels: [ "" ],
                datasets: [
                    {
                        label: "-",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: [ 0 ]
                    }
                ]
                @endif
            };
            new Chart($benefiters_per_medical_visits_canvas).Bar($data, {});
        })();
    </script>
@stop
