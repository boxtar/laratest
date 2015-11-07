@extends('layouts.master')

@section('title', 'Users')

@section('content')
<div class="content">
	<div class = "title">Users</div>
	<hr/>
	
	@foreach ($users as $user)
	
	<div><h4><a href="{{ action('UsersController@show', $user->profile_link) }}">{{ $user->name }}</a></h4></div>
	
	@endforeach
	
</div>
@stop

