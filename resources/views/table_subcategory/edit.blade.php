@extends('layouts.head')

@section('pageTitle') Edit subcategory @endsection

@section('content')
	<h1>Edit subcategory</h1>

	<form action="{{route('tablesubcategory_update', [$tableSubcategory->id, $tableSubcategory->slug])}}" method="POST">
		@csrf
		<input type="hidden" name="_method" value="PUT">
		<textarea name="title" id="form-content"></textarea>
		<button class="btn btn-success" type="submit">Submit</button>
	</form>

	@component('components.summernote', ['value' => $tableSubcategory->title])
		
	@endcomponent
@endsection