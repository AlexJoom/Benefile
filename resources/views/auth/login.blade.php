@extends('layouts.app')

@section('headLinks')
    <title>Login</title>
  <link href={{asset('css/common/loginRegister.css')}} rel="stylesheet" type="text/css">
  <link href={{asset('css/common/common.css')}} rel="stylesheet" type="text/css">
@stop


@section('mainBody')
<div class="container-fluid">
	<div class="row">
	    <div class="col-md-6">
            <img class="img-responsive" src={{asset('images/benefile-Logo.png')}}>
	    </div>
		<div id="login" class="col-md-6 benfile-back-color" style="height: 840px; display: table;">
			<div style="display: table-cell; vertical-align: middle;">
				<div class="title margin-bottom-50">Login</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{--<strong>Whoops!</strong> There were some problems with your input.<br><br>--}}
							{{--<ul>--}}
								{{--@foreach ($errors->all() as $error)--}}
									{{--<li>{{ $error }}</li>--}}
								{{--@endforeach--}}
							{{--</ul>--}}
						</div>
					@endif
					<form class="form-horizontal" role="form" method="POST" action="{{url('home')}}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

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

						<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
							<div class="col-md-6 centerDiv">
								<input type="password" class="inputFields" name="password" placeholder="Password">
								@if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
								<div>
								    <a class="clickMessage" href="{{ url('/password/email') }}">Ξεχάσατε τον κωδικό σας?</a>
								</div>
							</div>
						</div>

						{{--<div class="form-group">--}}
							{{--<div class="col-md-6 col-md-offset-4">--}}
								{{--<div class="checkbox">--}}
									{{--<label>--}}
										{{--<input type="checkbox" name="remember"> Remember Me--}}
									{{--</label>--}}
								{{--</div>--}}
							{{--</div>--}}
						{{--</div>--}}

						<div class="form-group">
							<div class="col-md-6 centerDiv" style="margin-top: 30px;">
								<button type="submit" class="inputFields submitColor no-border" style="margin-right: 15px;">
									Login
								</button>
                                <div class="clickMessage">
                                    <span class="font-weight-400">Δεν έχετε λογαριασμό?</span>&nbsp;&nbsp;
                                    <a class="clickMessage" href="{{ url('auth/register')}}">Εγγραφτείτε εδώ.</a>
                                </div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
