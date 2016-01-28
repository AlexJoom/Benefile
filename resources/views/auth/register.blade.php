@extends('layouts.mainLayout')

@section('headLinks')
    <title>Register</title>
    <link href={{asset('css/common/loginRegister.css')}} rel="stylesheet" type="text/css">
@stop

@section('mainBody')
    <div class="title margin-bottom-50">Register</div>
    {{--<div>--}}
        {{--<form class="form-horizontal" role="form" method="POST" action="/auth/register">--}}
        {{--<input>--}}
        {{--<input type="submit" value="Register">--}}
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        {{--</form>--}}
    {{--</div>--}}

    <div class="container-fluid font-weight-600">
    	<div class="row">
    		<div class="col-md-8 col-md-offset-2">
    			<div class="panel panel-default">
    				<div class="panel-body">
    					@if (count($errors) > 0)
    						<div class="alert alert-danger">
    							<!--<strong>Whoops!</strong> There were some problems with your input.<br><br>-->
    							<ul>
    								@foreach ($errors->all() as $error)
    									<li>{{ $error }}</li>
    								@endforeach
    							</ul>
    						</div>
    					@endif

    					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
    						<input type="hidden" name="_token" value="{{ csrf_token() }}">

                            {{-- name --}}
                            <div class="form-group">
                                <div class="div-custom-form">
                                    <input type="name" class="inputFields" name="name" value="{{ old('name') }}" placeholder="Name">
                                </div>
                            </div>

                            {{-- lastname --}}
                            <div class="form-group">
                                <div class="div-custom-form">
                                    <input type="lastname" class="inputFields" name="lastname" value="{{ old('lastname') }}" placeholder="Last name">
                                </div>
                            </div>

                            {{-- email--}}
    						<div class="form-group">
    							<div class="div-custom-form">
    								<input type="email" class="inputFields" name="email" value="{{ old('email') }}" placeholder="email">
    							</div>
    						</div>

                             {{--Password--}}
    						<div class="form-group">
    							<div class="div-custom-form">
    								<input type="password" class="inputFields" name="password" placeholder="password">
    							</div>
    						</div>

    						{{-- User Role --}}
    						<div class="form-group">
                                <div class="div-custom-form">
                                    <select class="inputFields" id="user-role" onchange="showDiv(this)" name="user_role_id">
                                      <option value="default">Select a role</option>
                                      <option value="2">Γιατρός</option>
                                      <option value="3">Νομικός Σύμβουλος</option>
                                      <option value="4">Κοινωνικός Σύμβουλος</option>
                                      <option value="5">Ψυχολόγος</option>
                                    </select>
                                </div>
                            </div>

                            {{-- User Sub role (if user is doctor) --}}
    						<div class="form-group">
                                <div class="div-custom-form">
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
                                </div>
                            </div>
                            {{--Register Button--}}
                          	<div class="">
                            	<div class="div-custom-form">
                            		<button type="submit" class="submitButton">Register</button>
                            	</div>
           					</div>

                            {{-- Already registered --}}
           					<div class="form-group">
                                <div class="div-custom-form">
           					        <a class="custom-form-link" href="{{url('/auth/login')}}">Already Registered</a>
           					    </div>
           					</div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
@stop

@section('scripts')
    <script>
        $("#user-subrole").hide();
        function showDiv(elem){
           if(elem.value == 2)
              document.getElementById('user-subrole').style.display = "inline";
        }
    </script>
@stop