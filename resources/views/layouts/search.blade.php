@extends('head')

@section('content')
	<div class="search-results">
		@if (count($results))
			@foreach ($results as $result)
				@php $item = DB::table($result->table_name)->where('id', $result->id)->get() @endphp
				@foreach ($item as $key)
					<div class="search-result">
						@if ($key->table_name === 'categories')
							<h5>
								<a href="{{route('category_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</h5>
						@elseif ($key->table_name === 'subcategories') 
							<h5>
								<a href="{{route('subcategory_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</h5>
						@elseif ($key->table_name === 'threads')
							<h5>
								<a href="{{route('thread_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</h5>
						@elseif ($key->table_name === 'users')
							<h5>
								{{ $key->username }}
							</h5>
						@elseif ($key->table_name === 'posts')
							<h5>
								{{ shorten_text($key->content) }}
							</h5>
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