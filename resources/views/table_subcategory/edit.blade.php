@extends('layouts.head')

@section('pageTitle') Edit subcategory @endsection

@section('content')
	<h1>Edit subcategory</h1>

	<form action="{{route('tablesubcategory_update', [$tableSubcategory->id, $tableSubcategory->slug])}}" method="POST">
		@csrf
		<input type="hidden" name="_method" value="PUT">
		<input type="text" name="title" id="title" />
		<button class="btn btn-success" type="submit">
			<span>{{ __('Submit') }}</span>
		</button>
	</form>
@endsection