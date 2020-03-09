@extends('layouts.head')

@section('pageTitle') Edit post @endsection

@section('content')
	<h1>Edit post</h1>

	<form action="{{route('post_update', [$post->id])}}" method="POST">
		@csrf
		<input type="hidden" name="_method" value="PUT">
		<textarea name="content" id="form-content"></textarea>
		<button class="btn btn-success" type="submit">Submit</button>
	</form>

	@component('components.summernote')
		@slot('value')
			{!! $post->content !!}
		@endslot
	@endcomponent
@endsection