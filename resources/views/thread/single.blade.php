@extends('layouts.app')

@section('content')
	<h1>Single thread</h1>

	@foreach ($posts as $post)
		<p>{{ $post->content }}</p>
		<p><a href="/post/{{$post->id}}">Visit</a></p>
	@endforeach
	<a href="{{url()->current()}}/new">Reply</a>
@endsection