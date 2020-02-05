@extends('layouts.app')

@section('pageTitle') Create new thread @endsection

@section('content')
	<h1>Create new thread in: {{ $subcategory->title }}</h1>

	<form action="{{explode('new', url()->current())[0]}}create" method="POST">
		@csrf

		<input class="bg-dark" type="text" name="title" id="title">

		<textarea name="content" id="content" value="Post"></textarea>
		
		<button type="submit">Submit</button>
	</form>
	@error('title') <p class="form-error">{{ __($message) }}</p> @enderror
	@error('content') <p class="form-error">{{ __($message) }}</p> @enderror
@endsection