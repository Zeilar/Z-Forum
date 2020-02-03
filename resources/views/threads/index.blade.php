@extends('layouts.app')

@section('content')
	<table class="table">
		<thead>
			<tr class="table-header bg-pink">
				<th class="py-3">{{ __('Title') }}</th>
				<th class="py-3">{{ __('Latest post') }}</th>
				<th class="py-3">{{ __('Posts') }}</th>
			</tr>
		</thead>
		<tbody>
			<tr class="table-category bg-dark">
				<th>{{ __($subcategory->title) }}</th>
				<th></th><th></th> <!-- to make sure the row is full width, becaues tables -->
			</tr>
			@foreach ($threads as $thread)
				<tr>
					<td><a href="/thread/{{$thread->title}}-{{$thread->id}}">{{ __($thread->title) }}</a></td>
					<td>Otto</td> <!-- latest post -->
					<td>@mdo</td> <!-- posts -->
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection