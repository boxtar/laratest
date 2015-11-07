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
					@if($viewer_is_owner)
						<a href="{{ action('PostsController@edit', [$user->profile_link, $post->id]) }}">
					@endif

					{!! $post->message !!}

					@if($viewer_is_owner)
						</a>
					@endif

				</h4>
			</article>
			<hr/>
		@endforeach
	@else
		<article>
			<h4>
				@if($viewer_is_owner)
					You have no posts yet. Get cracking!
				@else
					{!! $user->name !!} has no posts yet.
				@endif
			</h4>
		</article>
	@endif

	<br/>

	@if($viewer_is_owner)
		<p>
			<a class="btn btn-default" href="{{ action('PostsController@create', $user->profile_link) }}">
				New Post
			</a>
		</p>
	@endif
</div>
@stop