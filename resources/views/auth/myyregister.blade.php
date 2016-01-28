@extends('layouts.app')

@section('headLinks')
    <title>Register</title>
  <link href={{asset('css/common/loginRegister.css')}} rel="stylesheet" type="text/css">
@stop

@section('content')
<div class="container-fluid ">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="title margin-bottom-50">Register</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input class="inputFields" type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							{{--<label class="col-md-4 control-label">Name</label>--}}
							<div class="col-md-6">
								<input class="inputFields" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name">
							</div>
						</div>

						<div class="form-group">
							{{--<label class="col-md-4 control-label">E-Mail Address</label>--}}
							<div class="col-md-6">
								<input class="inputFields" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
							</div>
						</div>

						<div class="form-group">
							{{--<label class="col-md-4 control-label">Password</label>--}}
							<div class="col-md-6">
								<input class="inputFields" type="password" class="form-control" name="password" placeholder="password">
							</div>
						</div>

						<div class="form-group">
							{{--<label class="col-md-4 control-label">Confirm Password</label>--}}
							<div class="col-md-6">
								<input class="inputFields" type="password" class="form-control" name="password_confirmation" placeholder="password confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="submitButton">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
