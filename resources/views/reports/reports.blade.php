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
        <div class="row">
            <div class="col-md-12">
                {{-- Benefiters marital statuses --}}
                <div class="col-md-6">
                    <canvas id="maritalStatusReport" height="400" width="400"></canvas>
                </div>
            </div>
        </div>
        {{-- Benefiters marital statuses end --}}
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
                {{-- Medical visits location --}}
                <div id="medical-visits-location" class="col-md-6">
                    <canvas id="medical-visits-location-canvas" height="400" width="400"></canvas>
                </div>
                {{-- Medical visits location end --}}
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
    </div>
@stop

@section('panel-scripts')
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/reports/reports.js') }}"></script>
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
	// TODO REMOVE!!! left for new pie charts reference ONLY!!!
        /*(function(){
            var $benefiters_work_title = $("#benefiters-work-title-canvas").get(0).getContext("2d");
            var $data = [
                @if(!empty($benefiters_work_title))
                    @foreach($benefiters_work_title as $key => $value)
                        {
                            value: {!! $value !!},
                            color: "#46BFBD",
                            highlight: "#46BFBD",
                            @if($key == "")
                            label: "-"
                            @else
                            label: "{!! $key !!}"
                            @endif
                        },
                    @endforeach
                @endif
            ];
            var $options = {segmentShowStroke: true};
            new Chart($benefiters_work_title).Pie($data, $options);
        })();*/
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
@stop
