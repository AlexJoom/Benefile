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
	<!-- Benefiters marital statuses -->
	<div class="row">
            <div class="col-md-12">
		<canvas id="maritalStatusReport" width="400" height="400"></canvas>
	    </div>
	</div>
	<!-- Benefiters marital statuses end -->
                <div id="benefiters-work-title" class="col-md-6">
                    <canvas id="benefiters-work-title-canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('panel-scripts')
<script src="{{ asset('js/chart.min.js') }}"></script>
	<script>
		(function() {
			 var ctx = document.getElementById("maritalStatusReport").getContext("2d");
			 var chart = {
				labels: [ @foreach ($benefitersMaritalStatuses as $maritalStatus) {!! json_encode($maritalStatus->marital_status_title) !!}, @endforeach ],
				datasets: [
					{
					label: "My Data",                    
					data: [ @foreach ($benefitersMaritalStatuses as $maritalStatus) {!! json_encode($maritalStatus->marital_counter) !!}, @endforeach ],
					}
				]
			};
			var myLineChart = new Chart(ctx).Line(chart, {
			bezierCurve: false
			});
		})();
	</script>
    <script>
        (function(){
            var $benefiters_work_title = $("#benefiters-work-title-canvas").get(0).getContext("2d");
            var $data = [
                @if(!empty($benefiters_work_title))
                    @foreach($benefiters_work_title as $key => $value)
                        {
                            value: {{ $value }},
                            color: "#46BFBD",
                            label: {{ $key }}
                        },
                    @endforeach
                @endif
            ];
            var $options = {segmentShowStroke: true};
            new Chart($benefiters_work_title).Pie($data, $options);
        })();
    </script>
@stop
