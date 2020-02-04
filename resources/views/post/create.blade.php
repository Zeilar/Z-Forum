@extends('layouts.app')

@section('pageTitle') Post comment @endsection

@section('content')
	<h1>Post comment in thread: {{ $thread->title }}</h1>

	<form action="{{explode('new' ,url()->current())[0]}}create" method="POST">
		@csrf

		<textarea class="bg-dark" name="content" id="content" value="Content"></textarea>
		
		<button type="submit">Submit</button>
	</form>
	@error('content') <p class="form-error">{{ $message }}</p> @enderror
@endsection