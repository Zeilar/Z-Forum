{{-- Passed variables: $category --}}
@extends('layouts.head')

@section('content')
	<form action="{{route('subcategory_store', [$category->id, $category->slug])}}" method="POST">
		@csrf

		<div class="form-group">
			<input class="form-control" type="text" placeholder="Title" name="title" id="title" />
		</div>
		
		<button type="submit" class="btn btn-success">
			<span>{{ __('Submit') }}</span>
		</button>
	</form>
@endsection