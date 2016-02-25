<?php
    $p = 'auth/password.';
?>

@extends('layouts.login-register-layout')

@section('title')
    <title>Reset Password</title>
@stop


@section('log-content')
    <div id="reset-password">
        <div class="reset-password-text margin-bottom-50"><b>@lang($p.'forgot_password')</b></div>
        <div class="reset-password-text">
            @lang($p.'account_email')
        </div>
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>@lang($p.'error_message')</strong>
                     <br>
                     @lang($p.'info_confirmation')<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{url('/password/email')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <div class="col-md-6 centerDiv">
                        <input type="email" class="inputFields" name="email" value="{{ old('email') }}" placeholder="email">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 centerDiv">
                        <button type="submit" class="inputFields submitColor no-border margin-bottom-50">
                            @lang($p.'reset')
                        </button>

                        <div class="clickMessage no-float text-center">
                            <a href="{{ url('auth/login')}}" class="white">@lang($p.'return')</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
