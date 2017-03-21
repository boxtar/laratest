@extends('layouts.master')

@section('title', 'Make a Post')

@section('content')

	<div class="title">Post to MVC</div>

	<hr/>
	
	<div class="small-container">
		
		@include('errors.list')
		
		{!! Form::open(['method'=>'PUT', 'route' => ['posts.store', 'id' => $user->profile_link]]) !!}

			@include('pages.posts.partials.form', ['submitButtonText' => 'Create Post'])

		{!! Form::close() !!}
		
	</div>

@endsection