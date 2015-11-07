@extends('layouts.master')

@section('title', 'Groups')

@section('content')
<div class="content">
	<div class = "title">Groups</div>
	<hr/>

	@if(Auth::check())
		<a class="btn btn-default" href="{{ action('GroupsController@create') }}">New Group</a><br/>
	@endif

	<h2>Latest Groups</h2><br/>
	@foreach ($groups as $group)
	
	<div><h4><a href="{{ action('GroupsController@show', $group->profile_link) }}">{{ $group->name }}</a></h4></div>
	
	@endforeach
	
</div>
@stop