@extends('layouts.master')

@section('title', 'Join the MVC')

@section('content')

<div class="title">Join the MVC</div>

<div class="small-container">
	
	@include('errors.list')
	
	<form method="POST" action="/auth/register">
		{!! csrf_field() !!}

		@include('auth.partials.register_form', ['submitButtonText' => 'Register'])
	</form>
</div>

@stop