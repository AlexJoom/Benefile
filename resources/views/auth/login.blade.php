<?PHP
    $p = 'auth/login.';
?>

@extends('layouts.login-register-layout')

@section('title')
<title>Login</title>
@stop

@section('log-content')
<div id="login">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{url('auth/login')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{-- email --}}
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-6 centerDiv">
                    <input type="email" class="inputFields" name="email" value="{{ old('email') }}" placeholder="e-mail">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- password --}}
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-6 centerDiv">
                    <input type="password" class="inputFields" name="password" placeholder=@lang($p.'password')>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <div>
                        <b><a class="clickMessage" href="{{ url('/password/email') }}">@lang($p.'forgot_password')</a></b>
                    </div>
                </div>
            </div>

            {{-- Login button --}}
            <div class="form-group">
                <div class="col-md-6 centerDiv">
                    <button type="submit" class="inputFields submitColor no-border" >
                        @lang($p.'login')
                    </button>
                    <p class="clickMessage">
                       @lang($p.'no_account')
                       &nbsp;
                        <b><a class="white" href="{{ url('auth/register')}}">@lang($p.'register_here')</a></b>
                    </p>
                </div>
            </div>

        </form>
    </div>
</div>
@stop
