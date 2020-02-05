@extends('layouts.app')

@section('content')
	@if ($post)
		<div class="card mb-4">
			<h3>{{ $post->content }}</h3>
			<span>Posted at: {{ $post->created_at }}</span>
		</div>
	@else
		<p>The post you were looking for could not be found.</p>
	@endif
@endsection