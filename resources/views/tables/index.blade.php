@extends('layouts.app')

@section('content')
	<table class="table">
		<thead>
			<tr class="table-header bg-pink">
				<th class="py-3">{{ __('Sub category') }}</th>
				<th class="py-3">{{ __('Latest post') }}</th>
				<th class="py-3">{{ __('Threads') }}</th>
				<th class="py-3">{{ __('Posts') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($tables as $table)
				<tr class="table-category bg-dark">
					<th>{{ __($table['table_category']->title) }}</th>
					<th></th><th></th><th></th> <!-- to make sure the row is full width, becaues tables -->
				</tr>
				@foreach ($table['table_subcategories'] as $table_subcategory)
					<tr>
						<td><a href="/category/{{$table_subcategory->title}}-{{$table_subcategory->id}}">{{ __($table_subcategory->title) }}</a></td>
						<td>Otto</td> <!-- latest post -->
						<td>@mdo</td> <!-- threads -->
						<td>@mdo</td> <!-- posts -->
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
@endsection