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

           <div class="white">
               <div class="bottomDiv" >
                  @lang($p.'need_help')<a class="white" href="#"><b>@lang($p.'contact')</b></a>
              </div>
          </div>
        </div>
    </div>
@stop