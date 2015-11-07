@extends('layouts.master')

@section('title')
Edit {!! $user->name !!}
@endsection

@section('content')

	<div class="title">Edit {!! $user->name !!}</div>
	
	<hr/>

	<div class="small-container">
		
		@include('errors.list')
		
		{!! Form::model($user, ['method' => 'PATCH', 'action' => ['UsersController@update', $user->profile_link]]) !!}

			@include('pages.users.partials.form', ['submitButtonText' => 'Edit User'])

		{!! Form::close() !!}
	</div>
@stop