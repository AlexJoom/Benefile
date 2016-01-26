@extends('layouts.mainLayout')

@section('headLinks')
    <title>Login</title>
    <link href={{asset('css/common/loginRegister.css')}} rel="stylesheet" type="text/css">
@stop

@section('mainBody')
    <div class="col-md-8 col-md-offset-2 form-content">
        <div class="title margin-bottom-50">Login</div>
        @foreach($errors->all() as $error)
            <p class="alert alert-danger">{!!$error!!}</p>
        @endforeach
        {!!Form::open(['url'=>'/login','class'=>'form form-horizontal','style'=>'margin-top:50px'])!!}
        <div class="inputFields">
            <div class="col-sm-8">
                {!! Form::text('email',Input::old('email'),['class'=>'inputFields', 'placeholder' =>'email']) !!}
            </div>
        </div>
        <div class="inputFields">
            <div class="col-sm-8">
                {!! Form::password('password',['class'=>'inputFields', 'placeholder' =>'password']) !!}
            </div>
        </div>
        <div class="text-center">
            {!!Form::submit('Login',['class'=>'submitButton'])!!}
        </div>
        {!!Form::close()!!}
    </div>
@stop