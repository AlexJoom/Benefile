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
                    <input type="password" class="inputFields" name="password" placeholder="Κωδικός">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <div>
                        <b><a class="clickMessage" href="{{ url('/password/email') }}">Ξεχάσατε τον κωδικό σας;</a></b>
                    </div>
                </div>
            </div>

            {{-- Login button --}}
            <div class="form-group">
                <div class="col-md-6 centerDiv">
                    <button type="submit" class="inputFields submitColor no-border" >
                        Είσοδος
                    </button>
                    <p class="clickMessage">
                       Δεν έχετε λογαριασμό;&nbsp;
                        <b><a class="white" href="{{ url('auth/register')}}">Εγγραφείτε εδώ.</a></b>
                    </p>
                </div>
            </div>

        </form>
    </div>
</div>
@stop
