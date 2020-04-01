@extends('head')

@section('pageTitle')
	{{ __('Create new thread in ') . $subcategory->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('thread_new', $subcategory) }}
@endsection

@section('content')
	<h1>Create new thread in: {{ $subcategory->title }}</h1>

	<form action="{{route('thread_store', [$subcategory->id, $subcategory->slug])}}" method="POST">
		@csrf

		<input type="text" name="title" id="title" value="{{old('title')}}">

		<textarea name="content" id="form-content" value="Post">{{ old('content') }}</textarea>
		
		<button type="submit">Submit</button>
	</form>
	@error('title') <p class="form-error">{{ __($message) }}</p> @enderror
	@error('content') <p class="form-error">{{ __($message) }}</p> @enderror
@endsection