@extends('layouts.app')

@section('headLinks')
    <title>Register</title>
  <link href={{asset('css/common/loginRegister.css')}} rel="stylesheet" type="text/css">
  <link href={{asset('css/common/common.css')}} rel="stylesheet" type="text/css">
@stop

@section('mainBody')

    <div class="row">
        <div class="col-md-6">
            <img class="img-responsive" src={{asset('images/benefile-Logo.png')}}>
        </div>
            {{-- class "panel panel-default" remove from below  --}}
            <div class="col-md-6 benfile-back-color" style="height: 840px; display: table;">
                <div  style="display: table-cell; vertical-align: middle;">
                <div class="title margin-bottom-50">Register</div>
                <div class="panel-body">
                    {{--@if (count($errors) > 0)--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--<!--<strong>Whoops!</strong> There were some problems with your input.<br><br>-->--}}
                            {{--<ul>--}}
                                {{--@foreach ($errors->all() as $error)--}}
                                    {{--<li>{{ $error }}</li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    <form class="form-horizontal" role="form" method="POST" action="home">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        {{-- name --}}
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-6 centerDiv">
                                <input type="name" class="inputFields" name="name" value="{{ old('name') }}" placeholder="Name">
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
                                <input type="lastname" class="inputFields" name="lastname" value="{{ old('lastname') }}" placeholder="Last name">
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
                                <input type="password" class="inputFields" name="password" placeholder="password">
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
                                <input type="password" class="inputFields" name="password_confirmation" placeholder="Confirm password">
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
                                  <option value="default">Select a role</option>
                                  <option value="2">Γιατρός</option>
                                  <option value="3">Νομικός Σύμβουλος</option>
                                  <option value="4">Κοινωνικός Σύμβουλος</option>
                                  <option value="5">Ψυχολόγος</option>
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
                                  <option value="default">Select a sub role</option>
                                  <option value="1">Γενικός ιατρός</option>
                                  <option value="2">Νομικός Σύμβουλος</option>
                                  <option value="3">Κοινωνικός Σύμβουλος</option>
                                  <option value="4">Ψυχολόγος</option>
                                  <option value="5">Παιδίατρος</option>
                                  <option value="6">Γυναικολόγος</option>
                                  <option value="7">Οδοντίατρος</option>
                                  <option value="8">Δερματολόγος</option>
                                  <option value="9">Ορθοπεδικός</option>
                                  <option value="10">Καρδιολόγος</option>
                                  <option value="11">Οφθαλμίατρος</option>
                                  <option value="11">Ψυχίατρος</option>
                                  <option value="11">Νευρολόγος</option>
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
                            <div class="col-md-6 centerDiv"  style="margin-top: 30px;">
                                <button type="submit" class="inputFields submitColor no-border"  style="margin-right: 15px;">Register</button>
                                <div class="clickMessage">
                                    <span class="font-weight-400">Έχετε ήδη λογαριασμό?</span>&nbsp;&nbsp;
                                    <a class="clickMessage font-weight-700" href="{{ url('/auth/register')}}">Πατήστε εδώ.</a>
                                </div>
                            </div>
                        </div>

                        {{-- Already registered --}}
                        <div class="form-group">
                            <div class="div-custom-form">

                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
    </div>
@stop

@section('scripts')
    <script>
        $("#user-subrole").hide();
        function showDiv(elem){
           if(elem.value == 2){
              document.getElementById('user-subrole').style.display = "inline";
          }else{
                  $("#user-subrole").hide();
               }
        }
    </script>
@stop