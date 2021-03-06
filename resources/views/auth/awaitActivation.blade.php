<?php
    $p = 'auth/awaitActivation.';
?>

@extends('layouts.login-register-layout')

@section('title')
    <title>@lang($p.'awaiting_activation')</title>
@stop

@section('log-content')
    <div id="reset">
        <div class="panel-body">
           <div class="reset-password-text margin-bottom-50">@lang($p.'registratio_message_1')</div>
           <div class="reset-password-text">
               <b>@lang($p.'registratio_message_2')</b>
           </div>

           <div class="text-center margin-top-40 margin-bottom-50">
            <a class="logout-button" href="{{ url('auth/logout') }}">@lang($p.'logout')</a>
           </div>


        </div>
    </div>
    <div class="white margin-top-100">
        <div class="row">
            <div class="bottomDiv">
               @lang($p.'need_help')<a class="white" target="_blank" href="http://www.praksis.gr/el/επικοινωνια"><b>@lang($p.'contact')</b></a>
            </div>
        </div>
    </div>
@stop
