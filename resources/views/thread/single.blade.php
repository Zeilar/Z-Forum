@extends('layouts.app')

@section('content')
	<h1>Single thread</h1>

	@foreach ($thread->posts as $post)
		<p>{{ $post->content }}</p>
		<p><a href="/post/{{$post->id}}">Visit</a></p>
	@endforeach
	<a href="{{route('post_create', [$thread->title, $thread->id])}}">Reply</a>
@endsection