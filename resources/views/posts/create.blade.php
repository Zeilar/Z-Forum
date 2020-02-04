@extends('layouts.app')

@section('pageTitle') Post comment @endsection

@section('content')
	<h1>Post comment</h1>

	<form action="/thread/create" method="POST">
		@csrf

		<input class="bg-dark" type="text" name="title" id="title">
		
		<button type="submit">Submit</button>
	</form>
	@error('title') <p class="form-error">{{ $message }}</p> @enderror
@endsection