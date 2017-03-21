@extends('layouts.master')

@section('title')
{{ $user->name }}
@stop

@section('stylesheets')
	<link rel="stylesheet" href="{{ url()->asset('css/libs/dropzone.min.css') }}">
@endsection

@section('content')
<div class="content">
	<div class="col-md-12">
		<img src="{{ route('users.getImage', [$user->profile_link, $user->avatar]) }}" alt="avatar">
	</div>
	<div class = "">
		<h1>{{ $user->name }}</h1>
	</div>
	<h5>Email: {{ $user->email }}</h5>
	<p>Created: <small>{{ $user->created_at->diffForHumans() }}</small></p>
	<br/>
	<h5>
		<a class="btn btn-default" href="{!! action('PostsController@index', [$user->profile_link]) !!}">
			{{ $user->name }}'s Posts
		</a>

		<a class="btn btn-default" href="{!! route('users.groups', [$user->profile_link]) !!}">
			{{ $user->name }}'s Groups
		</a>

		@if($user->id === Auth::id())
			<a class="btn btn-default" href="{!! route('users.edit', [$user->profile_link]) !!}">
				Edit Profile
			</a>
		@endif
	</h5>


	@unless(empty($images))
		<div class="container gallery">
			<div class="row">
				@foreach($images as $image)

					<div class="col-md-3 gallery__image">

						@can('manage_media', $user)
						<form action="{{route('users.destroyImage', [$user->profile_link, $image])}}" method="post">
							<input type="submit" value="Delete">
							<input type="hidden" name="_method" value="DELETE">
							{{ csrf_field() }}
						</form>
						@endcan
						
						@can('manage_media', $user)
						<a href="/testing/{{ $image }}">
						@endcan
							<img src="{{ route('users.getImage', [$user->profile_link, $image]) }}" alt="image">
						@can('manage_media', $user)
						</a>
						@endcan

					</div>

				@endforeach
			</div>
		</div>

	@endunless


	@can('manage_media', $user)

		<div class="small-container">
			<h3 class="text-center">Add Some Graphix</h3>

			<form action="{{ route('users.storeImage', $user->profile_link) }}"
				  class="dropzone"
				  id="addImagesForm">

				{{ csrf_field() }}
				<input type="hidden" name="_method" value="PUT">

			</form>
		</div>
		
	@endcan
	
</div>
@stop

@section('scripts')
	<script src="{{ url()->asset('js/libs/dropzone.min.js') }}"></script>
	<script>
		Dropzone.options.addImagesForm = {
			paramName: 'image',
			maxFilesize: 3,
			acceptedFiles: '.jpg, .jpeg, .png, .bmp'

		}
	</script>
@endsection

