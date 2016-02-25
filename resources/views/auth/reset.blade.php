<?php
    $p = 'auth/reset.';
?>

@extends('layouts.login-register-layout')

@section('title')
    <title>Reset Password</title>
@stop

@section('log-content')
    <div id="reset">
        <div class="reset-password-text margin-bottom-50">@lang($p.'reset_pass')</div>
        <div class="panel-body">

            <form class="form-horizontal" role="form" method="POST" action="{{url('/password/reset')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- email --}}
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
                        <input type="password" class="inputFields" name="password_confirmation" placeholder=@lang($p.'confirm_pass')>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                {{--Register Button--}}
                <div class="form-group">
                    <div class="col-md-6 centerDiv">
                        <button type="submit" class="inputFields submitColor no-border no-padding-left">@lang($p.'reset_password')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
