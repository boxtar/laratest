@extends('layouts.master')

@section('title')
{{ $user->name }}
@stop

@section('stylesheets')
	<link rel="stylesheet" href="{{ url() }}/css/libs/dropzone.min.css">
@endsection

@section('content')
<div class="content">
	<div class="col md-12 text-center">
		<img src="{{ url( 'users/' . $user->profile_link . '/get-image/' . $user->avatar ) }}" alt="avatar">
	</div>
	<div class = "title">{{ $user->name }}</div>
	<hr/>
	<h4>{{ $user->email }}</h4>
	<p>Created: <small>{{ $user->created_at->diffForHumans() }}</small></p>
	<br/>
	<h5>
		<a class="btn btn-default" href="{!! action('PostsController@index', [$user->profile_link]) !!}">
			{{ $user->name }}'s Posts
		</a>

		<a class="btn btn-default" href="{!! action('UsersController@groups', [$user->profile_link]) !!}">
			{{ $user->name }}'s Groups
		</a>

		@if($user->id === Auth::id())
			<a class="btn btn-default" href="{!! action('UsersController@edit', [$user->profile_link]) !!}">
				Edit Profile
			</a>
		@endif
	</h5>



	@can('edit', $user)

		<div class="small-container">
			<h3 class="text-center">Add Some Graphix</h3>

			<form action="{{action('UsersController@addImage', ['users' => $user->profile_link])}}"
				  class="dropzone"
				  id="addImagesForm"
			>

				{{ csrf_field() }}

			</form>
		</div>
		
	@endcan
	
</div>
@stop

@section('scripts')
	<script src="{{ url() }}/js/libs/dropzone.min.js"></script>
	<script>
		Dropzone.options.addImagesForm = {
			paramName: 'image',
			maxFilesize: 3,
			acceptedFiles: '.jpg, .jpeg, .png, .bmp'

		}
	</script>
@endsection

