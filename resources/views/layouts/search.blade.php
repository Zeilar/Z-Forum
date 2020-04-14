@extends('head')

@section('content')
	<div class="search-results">
		@if (count($results))
			@foreach ($results as $result)
				@php $item = DB::table($result->table_name)->where('id', $result->id)->get() @endphp
				@foreach ($item as $key)
					<div class="search-result">
						@if ($key->table_name === 'categories' || $key->table_name === 'subcategories' || $key->table_name === 'threads')
							<h4 class="result-title">
								{{ $key->title }}
							</h4>
						@else
							<h4 class="result-post">
								{{ shorten_text($key->content) }}
							</h4>
						@endif
					</div>
				@endforeach
			@endforeach
		@else
			<h1>{{ __('No results were found for this query') }}</h1>
		@endif
	</div>
	
	{{ $results->appends(request()->query())->links('layouts.pagination') }}
@endsection