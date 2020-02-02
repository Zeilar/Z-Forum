@extends('layouts.app')

@section('content')
	<table class="table">
		<thead class="bg-pink">
			<tr>
				<th>{{ __('Sub category') }}</th>
				<th>{{ __('Latest post') }}</th>
				<th>{{ __('Threads') }}</th>
				<th>{{ __('Posts') }}</th>
			</tr>
		</thead>
		<tbody>
			<tr class="bg-dark">
				<th>{{ __('Computers') }}</th>
				<th></th><th></th><th></th> <!-- to make sure the row is full width, becaues tables -->
			</tr>
			<tr>
				<td>Mark</td>
				<td>Otto</td>
				<td>@mdo</td>
				<td>@mdo</td>
			</tr>
			<tr>
				<td>Jacob</td>
				<td>Thornton</td>
				<td>@fat</td>
				<td>@mdo</td>
			</tr>
			<tr>
				<td>Larry</td>
				<td>the Bird</td>
				<td>@twitter</td>
				<td>@mdo</td>
			</tr>
		</tbody>
	</table>

	{{-- @foreach ($tableCategories as $table)
		<h2>{{ $table['table_category']->title }}</h2>
		@foreach ($table['table_subcategories'] as $table_subcategory)
			<p>{{ $table_subcategory->title }}</p>
		@endforeach
	@endforeach --}}

	@foreach ($tableSubcategories as $cat)
		{{var_dump($cat->tableCategory->title)}}
	@endforeach
@endsection