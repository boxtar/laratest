@extends('layouts/master')

@section('title', 'Login')

@section('content')

@include('errors.list')

<div class="title">Login</div>

<div class="small-container">
	
	<form method="POST" action="/auth/login">
		{!! csrf_field() !!}

		<div class="form-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					{!! Form::label('login_name', 'E-mail/Username: ') !!}
				</div>
				<div class="panel-body">
					{!! Form::text('login_name', old('login_name'), ['class'=>'form-control']) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					{!! Form::label('password', 'Password: ') !!}
				</div>
				<div class="panel-body">
					{!! Form::password('password', ['class'=>'form-control']) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::submit("Login", ['class'=>'btn btn-primary']) !!}
		</div>

		<br/>
		<div class="form-group">
			<input type="checkbox" name="remember"> Remember Me
		</div>

	</form>
	
</div>

@endsection