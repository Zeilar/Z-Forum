@extends('layouts.app')

@section('content')
	<h1>Home</h1>

	@if ($threads)
		@foreach ($threads as $thread)
			<div class="bg-dark mb-4">
				<h3>Thread title: {{ $thread->title }}</h3>
				<h3>Thread category: {{ $thread->category }}</h3>
				<a href="/thread/{{$thread->id}}">Visit</a>
			</div>
		@endforeach
	@endif
@endsection