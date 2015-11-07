@extends('layouts.master')

@section('title')
{{ $user->name }}
@stop

@section('content')
<div class="content">
	<div class = "title">{{ $user->name }}</div>
	<hr/>
	<h4>{{ $user->email }}</h4>
	<p>Created: <small>{{ $user->created_at->diffForHumans() }}</small></p>
	<br/>
	<h5>
		<a class="btn btn-default" href="{!! action('PostsController@index', [$user->profile_link]) !!}">
			View Posts
		</a>
		@if($user->id === Auth::id())
			<a class="btn btn-default" href="{!! action('UsersController@edit', [$user->profile_link]) !!}">
				Edit Profile
			</a>
		@endif
	</h5>
</div>
@stop

