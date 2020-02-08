@extends('layouts.head')

@section('content')
	<form action="{{route('tablesubcategory_store', [$tableCategory->title, $tableCategory->id])}}" method="POST">
		@csrf

		<div class="form-group">
			<input class="form-control" type="text" placeholder="Title" name="title" id="title" />
		</div>
		
		<button type="submit" class="btn btn-danger">Submit</button>
	</form>
@endsection