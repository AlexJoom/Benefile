@extends('layouts.mainLayout')

@section('headLinks')
    <title>Login</title>
  <link href={{asset('css/common/loginRegister.css')}} rel="stylesheet" type="text/css">
@stop


@section('mainBody')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="title margin-bottom-50">Login</div>
				<div class="panel-body font-weight-600">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="/auth/login">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">

							<div class="col-md-6">
								<input type="email" class="inputFields" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">
							</div>
						</div>

						<div class="form-group">

							<div class="col-md-6">
								<input type="password" class="inputFields" name="password" placeholder="Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="submitButton" style="margin-right: 15px;">
									Login
								</button>

								<a href="/password/email">Forgot Your Password?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
