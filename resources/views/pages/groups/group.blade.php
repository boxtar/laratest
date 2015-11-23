@extends('layouts.master')

@section('title')
{{ $group->name }}
@stop

@section('content')
<div class="content">
	<div class = "title">
		{{ $group->name }}
	</div>

	<hr/>

	@can('edit_details', $group)
		<a class="btn btn-default" href="{!! action('GroupsController@edit', [$group->profile_link]) !!}">
			Edit Group
		</a>
	@endcan

	<h4>{{ $group->profile_link }}</h4>
	<p>Created: <small>{{ $group->created_at->diffForHumans() }}</small></p>

	<br/>



	<br/>

	@unless($group->members->isEmpty())
		<h4>Members of {!! $group->name !!}</h4>
		@foreach($group->members as $member)
			<p>{!! $member->name !!}</p>
		@endforeach
	@endunless
</div>
@stop

