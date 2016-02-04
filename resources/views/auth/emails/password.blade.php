@extends('layouts.login-register-layout')

@section('title')
    <title>Reset Password</title>
@stop

@section('log-content')
Click here to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
@stop