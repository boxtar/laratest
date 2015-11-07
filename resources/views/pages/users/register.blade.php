@extends('layouts.master')

@section('title', 'Join the MVC')

@section('content')

	<div class="title">Join the MVC</div>

	<hr/>
	
	<div class="small-container">
		
		@include('errors.list')
		
		{!! Form::open(['action' => 'UsersController@store']) !!}

			@include('pages.users.partials.form', ['submitButtonText' => 'Create Account'])

		{!! Form::close() !!}
		
	</div>
@stop