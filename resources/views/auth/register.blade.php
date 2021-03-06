<?php
    $p = 'auth/register.';
?>

@extends('layouts.login-register-layout')

@section('title')
<title>Register</title>
@stop

@section('log-headLinks')
  <link href={{asset('css/common/loginRegister.css')}} rel="stylesheet" type="text/css">
  <link href={{asset('css/common/common.css')}} rel="stylesheet" type="text/css">
@stop

@section('log-content')
<div id="register">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{url('auth/register')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{-- name --}}
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-md-6 centerDiv">
                    <input type="name" class="inputFields" name="name" value="{{ old('name') }}" placeholder=@lang($p.'name')>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- lastname --}}
            <div class="form-group {{ $errors->has('lastname') ? ' has-error' : '' }}">
                <div class="col-md-6 centerDiv">
                    <input type="lastname" class="inputFields" name="lastname" value="{{ old('lastname') }}" placeholder=@lang($p.'lastname')>
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- email--}}
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-6 centerDiv">
                    <input type="email" class="inputFields" name="email" value="{{ old('email') }}" placeholder="email">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

             {{--Password--}}
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-6 centerDiv">
                    <input type="password" class="inputFields" name="password" placeholder=@lang($p.'password')>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- Confirm password --}}
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <div class="col-md-6 centerDiv">
                    <input type="password" class="inputFields" name="password_confirmation" placeholder=@lang($p.'confirm_password')>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- User Role --}}
            <div class="form-group">
                <div class="col-md-6 centerDiv">
                    <select class="inputFields" id="user-role" onchange="showDiv(this)" name="user_role_id">
                      <option value="0" disabled selected>@lang($p.'role')</option>
                      <option value="2">@lang($p.'doctor')</option>
                      <option value="3">@lang($p.'counsel')</option>
                      <option value="4">@lang($p.'social_advisor')</option>
                      <option value="5">@lang($p.'psychologist')</option>
                    </select>
                    @if ($errors->has('user_role_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_role_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- User Sub role (if user is doctor) --}}
            <div class="form-group">
                <div class="col-md-6 centerDiv">
                    <select class="inputFields" id="user-subrole" name="user_subrole_id">
                        <option value="0" disabled selected>@lang($p.'specialty')</option>

                        @foreach ($subroles as $subrole)
                            <option value="{!! $subrole->id !!}">{!! $subrole->subrole !!}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('user_subrole_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_subrole_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{--Register Button--}}
            <div class="form-group">
                <div class="col-md-6 centerDiv">
                    <button type="submit" class="inputFields submitColor no-border no-padding-left">@lang($p.'register')</button>
                    <div class="clickMessage">
                        <span class="font-weight-400">@lang($p.'registered')</span>&nbsp;&nbsp;
                        <a class="clickMessage font-weight-700" href="{{ url('auth/login')}}">@lang($p.'click')</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('log-scripts')
    <script>
        $("#user-subrole").hide();
        function showDiv(elem){
           if(elem.value == 2){
              document.getElementById('user-subrole').style.display = "inline";
          }else{
                  $("#user-subrole").val("0");
                  $("#user-subrole").hide();
               }
        }
    </script>
@stop
