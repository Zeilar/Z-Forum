@extends('layouts.app')

@section('content')
	<h1>Thread</h1>
	<h3>Thread title: {{ $thread->title }}</h3>
	<h3>Thread category: {{ $thread->category }}</h3>

	<h1>Post in thread</h1>
	<h3>Post content:</h3>
	<br>
	@foreach ($posts as $post)
		<p class="bg-dark">{{ $post->content }}</p>
	@endforeach
@endsection