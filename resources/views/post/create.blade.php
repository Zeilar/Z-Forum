@extends('layouts.head')

@section('pageTitle') Post comment @endsection

@section('content')
	<h1>Post comment in thread: {{ $thread->title }}</h1>

	<form action="{{route('post_store', [$thread->id, $thread->slug])}}" method="POST">
		@csrf

		<textarea class="bg-dark" name="content" id="form-content"></textarea>
		
		<button type="submit">Submit</button>
	</form>
	@error('content') <p class="form-error">{{ $message }}</p> @enderror
@endsection