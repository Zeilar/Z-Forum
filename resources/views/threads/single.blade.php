@extends('layouts.app')

@section('content')
	<h1>Single thread</h1>

	@foreach ($posts as $post)
		<p>{{ $post->content }}</p>
	@endforeach
@endsection