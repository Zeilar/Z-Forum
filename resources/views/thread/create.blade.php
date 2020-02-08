@extends('layouts.head')

@section('pageTitle') Create new thread @endsection

@section('content')
	<h1>Create new thread in: {{ $subcategory->title }}</h1>

	<form action="{{route('thread_store', [$subcategory->title, $subcategory->id])}}" method="POST">
		@csrf

		<input class="bg-dark" type="text" name="title" id="title">

		<textarea name="content" id="form-content" value="Post"></textarea>
		
		<button type="submit">Submit</button>
	</form>
	@error('title') <p class="form-error">{{ __($message) }}</p> @enderror
	@error('content') <p class="form-error">{{ __($message) }}</p> @enderror
@endsection