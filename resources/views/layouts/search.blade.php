@extends('head')

@section('content')
	@dump($results)
	
	{{ $results->appends(request()->query())->links('layouts.pagination') }}

	{{-- @if (!count($results['categories']) && !count($results['subcategories']) && !count($results['threads']) && !count($results['users']))
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

	@if (count($results['categories']))
		<div class="search-categories">
			<h2 class="search-category">{{ __('Categories') }}</h2>
			@foreach ($results['categories'] as $category)
				<div class="search-category">
					<h4 class="category-title">{{ $category->title }}</h4>
				</div>
			@endforeach
		</div>
	@endif

	@if (count($results['subcategories']))
		<div class="search-subcategories">
			<h2 class="search-category">{{ __('Subcategories') }}</h2>
			@foreach ($results['subcategories'] as $subcategory)
				<div class="search-subcategory">
					<h4 class="subcategory-title">{{ $subcategory->title }}</h4>
				</div>
			@endforeach
		</div>
	@endif
	
	@if (count($results['threads']))
		<div class="search-threads">
			<h2 class="search-category">{{ __('Threads') }}</h2>
			@foreach ($results['threads'] as $thread)
				<div class="search-thread">
					<h4 class="thread-title">{{ $thread->title }}</h4>
				</div>
			@endforeach
		</div>
	@endif

	@if (count($results['posts']))
		<div class="search-posts">
			<h2 class="search-category">{{ __('Posts') }}</h2>
			@foreach ($results['posts'] as $post)
				<div class="search-post">
					<h4 class="post-title">{{ $post->content }}</h4>
				</div>
			@endforeach
		</div>
	@endif

	@if (count($results['users']))
		<div class="search-users">
			<h2 class="search-category">{{ __('Users') }}</h2>
			@foreach ($results['users'] as $user)
				<div class="search-user">
					<h4 class="user-title">{{ $user->title }}</h4>
				</div>
			@endforeach
		</div>
	@endif --}}
@endsection