@extends('layouts.app')

@section('pageTitle') Create new thread @endsection

@section('content')
	<h1>Create new thread</h1>

	<form action="/thread/create" method="POST">
		@csrf

		<input class="bg-dark" type="text" name="title" id="title">
		
		<button type="submit">Submit</button>
	</form>
	@error('title') <p class="form-error">{{ $message }}</p> @enderror
@endsection