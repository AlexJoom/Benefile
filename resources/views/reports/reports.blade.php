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
    <link href="{{ asset('css/reports/reports.css') }}" rel="stylesheet" type="text/css">
@stop

@section('main-window-content')
    {{-- REPORT: users numbers divided by their roles --}}
    <div class="users-report form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">@lang($p."users")</h1>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div id="doctors" class="col-xs-3">
                <img class="make-inline width-120px height-120px img-responsive" src="{{ asset('/img/benefile_3_doctors.jpg') }}" />
                <div class="make-inline">
                    <p class="users-title">@lang($p."doctors")</p>
                    <p class="users-counter">{{ $users_roles_count['doctors'] }}</p>
                </div>
            </div>
            <div id="legals" class="col-xs-3">
                <img class="make-inline width-120px height-120px img-responsive" src="{{ asset('/img/benefile_3_legals.jpg') }}" />
                <div class="make-inline">
                    <p class="users-title">@lang($p."legals")</p>
                    <p class="users-counter">{{ $users_roles_count['legals'] }}</p>
                </div>
            </div>
            <div id="psychologists" class="col-xs-3">
                <img class="make-inline width-120px height-120px img-responsive" src="{{ asset('/img/benefile_3_psychologists.jpg') }}" />
                <div class="make-inline">
                    <p class="users-title">@lang($p."psychologists")</p>
                    <p class="users-counter">{{ $users_roles_count['psychologists'] }}</p>
                </div>
            </div>
            <div id="socials" class="col-xs-3">
                <img class="make-inline width-120px height-120px img-responsive" src="{{ asset('/img/benefile_3_socials.jpg') }}" />
                <div class="make-inline">
                    <p class="users-title">@lang($p."socials")</p>
                    <p class="users-counter">{{ $users_roles_count['socials'] }}</p>
                </div>
            </div>
        </div>
        </div>
    </div>
    {{-- REPORT: Benefiters VS gerder --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">@lang($p."benefiters")</h1>
        </div>
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
    </div>
    {{-- REPORT: Benefiters marital statuses --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'h1-marital-status')</h1>
                </div>
                <div id="maritalStatusReport"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Medical visits location --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'h1-medical-visits-location')</h1>
                </div>
                <div id="medicalStatusReport"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters work titles --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'h1-work-title')</h1>
                </div>
                <div id="benefiters-work-title-chart" data-benefiters-registered="@lang($p."benefiters_registered")"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters work titles end --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'h1-medical-visits')</h1>
                </div>
                    <div id="benefiters-per-medical-visits-chart"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters age report end --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'h1-age-report')</h1>
                </div>
                <div id="ageReport"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters legal statuses --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'h1-legal-status')</h1>
                </div>
                <div id="legalStatusReport"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters registration numbers per month --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'h1-registration-status')</h1>
                </div>
                <div id="registrations_per_month" class="padding-left-right-15" data-registrations-per-month="@lang($p."registrations_per_month")"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters vs education --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'report-education')</h1>
                </div>
                <div id="benefiter_vs_education"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters vs doctor --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'report-doctors-type')</h1>
                </div>
                <div id="benefiter_vs_doctor_type"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters vs clinical conditions --}}
    <div class="benefiters-report form-section no-bottom-border">
        <div class="row">
            <div class="col-md-7 padding-right-0">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'report-clinical-condition')</h1>
                </div>
                <div id="benefiter_vs_clinical_conditions" data-number-of-benefiters="@lang($p."number_of_benefiters")"></div>
            </div>
            <div class="col-md-5 left-border">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'report-med-visits-per-month')</h1>
                </div>
                <div id="medical_visits_per_month" class="padding-left-right-15" data-medical-visits-per-month="@lang($p."medical_visits_per_month")"></div>
            </div>
        </div>
    </div>
    {{-- REPORT: Benefiters vs phycological support --}}
    <div class="benefiters-report form-section">
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'report-phycological-support')</h1>
                </div>
                <div id="benefiter_vs_phycological_support" data-number-of-benefiters="@lang($p."number_of_benefiters")"></div>
            </div>
        </div>
    </div>
@stop

@section('panel-scripts')
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/amcharts/amcharts.js') }}"></script>
    <script src="{{ asset('js/amcharts/pie.js') }}"></script>
    <script src="{{ asset('js/amcharts/serial.js') }}"></script>
    <script src="{{ asset('js/amcharts/radar.js') }}"></script>
    <script src="{{ asset('js/amcharts/themes/light.js') }}"></script>
    <script src="{{ asset('js/amcharts/amstock.js') }}"></script>
    <script src="{{ asset('js/reports/reports.js') }}"></script>
    <script src="{{ asset('js/records/selectReports.js') }}"></script>
    <script src="{{ asset('js/canvasjs.min.js') }}"></script>
    <script src="{{ asset('/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/records/custom_datepicker.js') }}"></script>
    <script src="{{ asset('js/forms.js') }}"></script>
    <script src="{{ asset('js/reports/reports-messages.js') }}"></script>

    <script>
        Lang.setLocale('gr');
    </script>
    {{-- Benefiter counter status graph --}}
	<script>
	</script>
    <script>
    {{-- Age report status graph --}}
    $(document).ready(function(){
        var chart = AmCharts.makeChart("ageReport", {
            "titles":[{'text':'','size':22}],
            "type": "pie",
            "fontSize": 16,
            "startDuration": 0,
            "theme": "light",
            "addClassNames": true,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false,
                "fontSize": 16
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
            "dataProvider": [
            @foreach ($benefiters_age as $age)
            {
                "benefiters": @if(json_encode($age->ageInYears) == 'null') "n/a" @else {!! json_encode($age->ageInYears) !!} + ' - ' + {!! json_encode($age->ageInYears + 9) !!} @endif ,
                "counter": {!! json_encode($age->counter) !!}
            },
            @endforeach
            ],
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
            "fontSize": 16,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false,
                "fontSize": 16
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
            "dataProvider": [
            @foreach ($benefitersMaritalStatuses as $maritalStatus)
            {
                "benefiters": {!! json_encode($maritalStatus->marital_status_title) !!},
                "counter": {!! json_encode($maritalStatus->marital_counter) !!}
            },
            @endforeach
            ],
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
            "fontSize": 16,
            "addClassNames": true,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false,
                "fontSize": 16
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
            "dataProvider": [
            @foreach ($benefiters_legal_statuses as $legalStatus)
            {
                "benefiters": {!! json_encode($legalStatus->description) !!},
                "litres": {!! json_encode($legalStatus->legal_counter) !!}
            },
            @endforeach
            ],
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
            "fontSize": 16,
            "addClassNames": true,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false,
                "fontSize": 16
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
            "dataProvider": [
            @foreach ($medical_visits_location as $medicalVisit)
            {
                "benefiters": {!! json_encode($medicalVisit->location) !!},
                "counter": {!! json_encode($medicalVisit->counter) !!}
            },
            @endforeach
            ],
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
    var chart = AmCharts.makeChart("benefiters-work-title-chart", {
        "type": "serial",
        "theme": "light",
        "fontSize": 16,
        "fontFamily": "Arial",
        "marginRight": 70,
        "rotate": true,
        "dataProvider": [
        @foreach($benefiters_work_title as $key => $value)
            {
            "benefiters": @if ($key != "") "{!! $key !!}" @else "-" @endif,
            "work description": "{!! $value !!}",
            },
        @endforeach
        ],
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": $("#benefiters-work-title-chart").data("benefiters-registered"),
            "fontSize": 16
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b> benefiters",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "work description"
        }],
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "benefiters",
        "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
        },
        "export": {
            "enabled": true
        }

    });
    </script>
    <script>
    var chart = AmCharts.makeChart("benefiters-per-medical-visits-chart", {
        "type": "serial",
        "theme": "light",
        "fontSize": 16,
        "fontFamily": "Arial",
        "marginRight": 70,
        "dataProvider": [
        @foreach($benefiters_medical_visits as $single_benefiters_medical_visit)
            {
            "benefiters": "{!! $single_benefiters_medical_visit->visits_counter !!}",
            "work description": "{!! $single_benefiters_medical_visit->benefiters_counter !!}",
            },
        @endforeach
        ],
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "@lang($p."medical-visit-y-title")",
            "fontSize": 16
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b> benefiters",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "work description",
            "lineColor" : "#3D6139"
        }],
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "benefiters",
        "categoryAxis": {
            "title": "@lang($p."medical-visit-x-title")",
            "gridPosition": "start",
            "labelRotation": 0
        },
        "export": {
            "enabled": true
        }

    });
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
    <script>
    var chart = AmCharts.makeChart("registrationStatusReport", {
        "type": "serial",
        "theme": "light",
        "fontSize": 16,
        "fontFamily": "Arial",
        "marginRight": 70,
        "dataProvider": [
        @foreach ($benefiters_count as $count)
            {
            "benefiters": {!! json_encode($count->created_at) !!},
            "registrations": {!! json_encode($count->idcounter) !!},
            },
        @endforeach
        ],
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "Benefiters registered",
            "fontSize": 16
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b> benefiters",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "registrations"
        }],
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "benefiters",
        "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
        },
        "export": {
            "enabled": true
        }

    });
    </script>
@stop
