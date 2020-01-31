@extends('layouts.app')

@section('content')
	<h1>Posts</h1>
	@if (count($posts))
		@foreach ($posts as $post)
			<div class="card bg-dark mb-4">
				<h3>{{ $post->content }}</h3>
				<span>Posted at: {{ $post->created_at }}</span>
				<a href="/posts/{{$post->id}}">Visit</a>
			</div>
		@endforeach
	@else
		<p>No posts were found.</p>
	@endif
@endsection