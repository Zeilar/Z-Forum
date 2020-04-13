@extends('head')

@section('content')
	<div class="search-posts">
		@if (count($results))
			@foreach ($results as $result)
				@php $item = DB::table($result->table_name)->where('id', $result->id)->get() @endphp
				<div class="search-post">
					<h4 class="post-title">
						@dump($item)
					</h4>
				</div>
			@endforeach
		@else
			<h1>{{ __('No results were found for this query') }}</h1>
		@endif
	</div>

	
	{{ $results->appends(request()->query())->links('layouts.pagination') }}
@endsection