@extends('layouts.master')

@section('title', 'Edit Post')

@section('content')
	
	<div class="title">Edit Post</div>
	
	<hr/>

	<div class="small-container">
		
		@include('errors.list')

		{!! Form::model($post, ['method' => 'PATCH', 'action' => ['PostsController@update', $user->profile_link, $post->id]]) !!}

			@include('pages.posts.partials.form', ['submitButtonText' => 'Edit Post'])

		{!! Form::close() !!}
	</div>

@endsection