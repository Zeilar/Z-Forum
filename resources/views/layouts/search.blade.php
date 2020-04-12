@extends('head')

@section('content')
	@if (!count($results['categories']) && !count($results['subcategories']) && !count($results['threads']) && !count($results['users']))
		<h1 class="search-header">
			{{ __('No results were found for:') }}
			<span>{{ request('search') }}</span>
		</h1>
	@else
		<h1 class="search-header">
			{{ __('Search results for:') }}
			<span>{{ request('search') }}</span>
		</h1>
	@endif
	
	@if (count($results['threads']))
		<div class="search-threads">
			@foreach ($results['threads'] as $thread)
				<div class="search-thread">
					<h4 class="thread-title">{{ $thread->title }}</h4>
				</div>
			@endforeach
		</div>
	@endif
@endsection