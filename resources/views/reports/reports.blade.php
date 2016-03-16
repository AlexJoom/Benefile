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
    <div class="users-report form-section">{{-- no-bottom-border"> --}}
        <div class="underline-header">
            <h1 class="record-section-header padding-left-right-15">@lang($p."users")</h1>
        </div>
	<!-- Users -->
        <div class="row">
            <div class="col-md-12">
                <div id="doctors" class="col-md-3">
                    <img class="make-inline width-85px" src="{{ asset('/img/benefile_3_doctors.jpg') }}" />
                    <div class="make-inline">
                        <p class="users-title">ΙΑΤΡΟΙ</p>
                        <p class="users-counter">{{ $users_roles_count['doctors'] }}</p>
                    </div>
                </div>
                <div id="legals" class="col-md-3">
                    <img class="make-inline width-85px" src="{{ asset('/img/benefile_3_legals.jpg') }}" />
                    <div class="make-inline">
                        <p class="users-title">ΔΙΚΗΓΟΡΟΙ</p>
                        <p class="users-counter">{{ $users_roles_count['legals'] }}</p>
                    </div>
                </div>
                <div id="psychologists" class="col-md-3">
                    <img class="make-inline width-85px" src="{{ asset('/img/benefile_3_psychologists.jpg') }}" />
                    <div class="make-inline">
                        <p class="users-title">ΨΥΧΟΛΟΓΟΙ</p>
                        <p class="users-counter">{{ $users_roles_count['psychologists'] }}</p>
                    </div>
                </div>
                <div id="socials" class="col-md-3">
                    <img class="make-inline width-85px" src="{{ asset('/img/benefile_3_socials.jpg') }}" />
                    <div class="make-inline">
                        <p class="users-title">ΚΟΙΝ. ΛΕΙΤΟΥΡΓΟΙ</p>
                        <p class="users-counter">{{ $users_roles_count['socials'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- Users end-->

    <div class="users-report form-section">{{-- no-bottom-border"> --}}
	<!-- Benefiters marital statuses -->
	<div class="row">
		<canvas id="maritalStatusReport" width="400" height="400"></canvas>
	</div>
	<!-- Benefiters marital statuses end -->
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
@stop
