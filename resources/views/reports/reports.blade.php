<?php
    $p = 'reports.';
?>

@extends('layouts.mainPanel')

@section('panel-title')
    @lang('layouts/mainPanel.reports')
@stop

@section('panel-headLinks')
    <link href="{{ asset('css/records/record_form.css') }}" rel="stylesheet" type="text/css">
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
    <div class="benefiters-report form-section">
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

        <div class="row">
            <div class="col-md-12">
                {{-- Benefiters marital statuses --}}
                <div class="col-md-6">
                    <canvas id="maritalStatusReport" height="400" width="400"></canvas>
                </div>
                {{-- Benefiters marital statuses end --}}
                {{-- Medical visits location --}}
                <div id="medical-visits-location" class="col-md-6">
                    <canvas id="medical-visits-location-canvas" height="400" width="400"></canvas>
                </div>
                {{-- Medical visits location end --}}
            </div>
        </div>
        {{-- Benefiters work titles --}}
        <div class="row">
            <div class="col-md-12">
                <div id="benefiters-work-title" class="col-md-12">
                    <canvas id="benefiters-work-title-canvas" height="400" width="1000"></canvas>
                </div>
            </div>
        </div>
        {{-- Benefiters work titles end --}}
        <div class="row">
            <div class="col-md-12">
                <div id="benefiters-per-medical-visits" class="col-md-12">
                    <canvas id="benefiters-per-medical-visits-canvas" height="400" width="1000"></canvas>
                </div>
            </div>
        </div>
        {{-- Benefiters age report end --}}
        <div class="row">
            <div class="col-md-12">
                <div id="benefiters-age-report" class="col-md-12">
                    <canvas id="benefiters-age-canvas" height="400" width="1000"></canvas>
                </div>
            </div>
        </div>
        {{-- Benefiters legal statuses --}}
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <canvas id="legalStatusReport" height="400" width="1000"></canvas>
                </div>
            </div>
        </div>
        {{-- Benefiters registration numbers per month --}}
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <canvas id="registrationStatusReport" height="400" width="1000"></canvas>
                </div>
            </div>
        </div>

        {{-- REPORT: Benefiters vs education --}}
        <div class="row">
            <div class="col-md-12">
                <div class="underline-header">
                    <h1 class="record-section-header padding-left-right-15">@lang($p.'report-education')</h1>
                </div>
                {{--<div id="benefiter_vs_education" class="col-md-6">--}}
                     {{--hidden values from controller (are used from js)--}}
                    {{--<input type="hidden" id="illiterate" value="{{ $report_benefiters_vs_education['illiterate'] }}" />--}}

                    {{--<canvas id="benefiter_vs_education_canvas" height="400" width="700"></canvas>--}}
                {{--</div>--}}

                {{-- second way--}}
                <div id="benefiter_vs_education"></div>


                {{-- third way--}}
                {{--<div id="chartContainer" style="height: 400px; width: 100%;">--}}

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
<script src="{{ asset('js/canvasjs.min.js') }}"></script>
    {{-- Benefiter counter status graph --}}
	<script>
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
    {{-- Legal status graph --}}
	<script>
		(function() {
			 var ctx = document.getElementById("legalStatusReport").getContext("2d");
			 var chart = {
                labels: [ @foreach ($benefiters_legal_statuses as $legalStatus) {!! json_encode($legalStatus->description) !!}, @endforeach ],
				datasets: [
					{
					label: "My Data",                    
                    fillColor: "rgba(220,220,220,0.5)",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [ @foreach ($benefiters_legal_statuses as $legalStatus) {!! json_encode($legalStatus->legal_counter) !!}, @endforeach ],
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
    {{-- Marital status graph --}}
	<script>
		(function() {
			 var ctx = document.getElementById("maritalStatusReport").getContext("2d");
			 var chart = {
				labels: [ @foreach ($benefitersMaritalStatuses as $maritalStatus) {!! json_encode($maritalStatus->marital_status_title) !!}, @endforeach ],
				datasets: [
					{
					label: "My Data",                    
                    fillColor: "rgba(220,220,220,0.5)",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
					data: [ @foreach ($benefitersMaritalStatuses as $maritalStatus) {!! json_encode($maritalStatus->marital_counter) !!}, @endforeach ],
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
    {{-- Age graph --}}
	<script>
		(function() {
			var ctx = document.getElementById("benefiters-age-canvas").getContext("2d");
			var chart = {
            labels: [ @foreach ($benefiters_age as $age) {!! json_encode($age->ageInYears) !!} + ' - ' + {!! json_encode($age->ageInYears + 9) !!} , @endforeach ],
				datasets: [
					{
					label: "My Data",
                    fillColor: "rgba(220,220,220,0.5)",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [ @foreach ($benefiters_age as $age) {!! json_encode($age->counter) !!}, @endforeach ],
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
            var $medical_visits_location_canvas = $("#medical-visits-location-canvas").get(0).getContext("2d");
            var $data = [
                @if(!empty($medical_visits_location))
                    <?php
                         $i = 0;
                         $colors = array(
                                         array("fill" => "rgba(255,0,0,0.5)", "highlight" =>  "rgba(255,0,0,0.75)"),
                                         array("fill" => "rgba(0,255,0,0.5)", "highlight" =>  "rgba(0,255,0,0.75)"),
                                         array("fill" => "rgba(0,0,255,0.5)", "highlight" =>  "rgba(0,0,255,0.75)"),
                                         array("fill" => "rgba(125,125,0,0.5)", "highlight" =>  "rgba(125,125,0,0.75)"),
                                         array("fill" => "rgba(125,0,125,0.5)", "highlight" =>  "rgba(125,0,125,0.75)"),
                                     );
                    ?>
                    @foreach($medical_visits_location as $single_medical_visits_location)
                        {
                            value: {!! $single_medical_visits_location->counter !!},
                            color: "{!! $colors[$i]['fill'] !!}",
                            highlight: "{!! $colors[$i]['highlight'] !!}",
                            @if($key == "")
                            label: "-"
                            @else
                            label: "{!! $single_medical_visits_location->location !!}"
                            @endif
                        },
                        <?php $i++; ?>
                    @endforeach
                @else
                    {
                        value: -1,
                        color: "rgba(125,125,125,0.5)",
                        highlight: "rgba(125,125,125,0.75)",
                        label: "-"
                    },
                @endif
            ];
            new Chart($medical_visits_location_canvas).Pie($data, {});
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
