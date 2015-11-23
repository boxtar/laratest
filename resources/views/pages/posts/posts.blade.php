@extends('layouts.master')

@section('title')
{{ $user->name . '\'s posts' }}
@stop

@section('content')
<div class="content">
	<div class = "title">{!! $user->name !!}'s Posts</div>
	<hr/>

	@if(!$posts->isEmpty())
		@foreach($posts as $post)
			<article>
				<h4>
					@can('updatePost', $post)
						<a href="{{ action('PostsController@edit', [$user->profile_link, $post->id]) }}">
					@endcan

					{!! $post->message !!}

                    @can('updatePost', $post)
						</a>
					@endcan

				</h4>
			</article>
			<hr/>
		@endforeach
	@else
		<article>
			<h4>
				@can('createPost', $user)
					You have no posts yet. Get cracking!
				@else
					{!! $user->name !!} has no posts yet.
				@endcan
			</h4>
		</article>
	@endif

	<br/>

	@can('createPost', $user)
		<p>
			<a class="btn btn-default" href="{{ action('PostsController@create', $user->profile_link) }}">
				New Post
			</a>
		</p>
	@endcan
</div>
@stop