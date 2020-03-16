@extends('layouts.head')

@section('pageTitle') Create new thread @endsection

@section('content')
	{{ Breadcrumbs::render('thread_new', $tableSubcategory) }}

	<h1>Create new thread in: {{ $tableSubcategory->title }}</h1>

	<form action="{{route('thread_store', [$tableSubcategory->id, $tableSubcategory->slug])}}" method="POST">
		@csrf

		<input type="text" name="title" id="title">

		<textarea name="content" id="form-content" value="Post"></textarea>
		
		<button type="submit">Submit</button>
	</form>
	@error('title') <p class="form-error">{{ __($message) }}</p> @enderror
	@error('content') <p class="form-error">{{ __($message) }}</p> @enderror
@endsection