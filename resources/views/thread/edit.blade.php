@extends('layouts.head')

@section('pageTitle') Edit thread @endsection

@section('content')
	@component('components.summernote', ['value' => $thread->title])
		
	@endcomponent
	
	<h1>Edit thread</h1>

	<form action="{{route('thread_update', [$thread->id, $thread->slug])}}" method="POST">
		@csrf
		<input type="hidden" name="_method" value="PUT">
		<input type="text" name="title" id="form-content" />
		<button class="btn btn-success" type="submit">Submit</button>
	</form>

@endsection