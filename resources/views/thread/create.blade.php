@extends('head')

@section('pageTitle')
	{{ __('Create new thread in ') . $subcategory->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('thread_new', $subcategory) }}
@endsection

@section('content')
	<div class="thread-form">
		<form action="{{route('thread_store', [$subcategory->id, $subcategory->slug])}}" method="POST">
			@csrf

			<fieldset>
				<legend>{{ __('Title') }}</legend>
				@error('title') <p style="color: red;">{{ $message }}</p> @enderror
				<input type="text" name="title" id="title" value="{{old('title')}}">
			</fieldset>

			@error('content') <p style="color: red;">{{ $message }}</p> @enderror
			<textarea name="content" id="form-content" value="{{ old('content') }}"></textarea>
			
			<button class="btn btn-success-full" type="submit">{{ __('Create thread') }}</button>
		</form>
	</div>
@endsection