<?php
    $p = 'auth/disabledUser.';
?>

@extends('layouts.login-register-layout')

@section('title')
    <title>@lang($p.'disabled_user')</title>
@stop

@section('log-content')
    <div id="reset">
        <div class="panel-body">
           <div class="reset-password-text margin-bottom-50">@lang($p.'disabled_title')</div>
           <div class="reset-password-text">
               <b>@lang($p.'disabled_text')</b>
           </div>

           <div class="white">
               <div class="bottomDiv" >
                  @lang($p.'need_help')<a class="white" href="#"><b>@lang($p.'contact')</b></a>
              </div>
          </div>
        </div>
    </div>
@stop
