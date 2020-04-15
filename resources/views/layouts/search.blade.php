@extends('head')

@section('content')
	<div class="search-results">
		@if (count($results))
			<h2>{{ __('Search results for: ') . request('query') }}</h2>
			@foreach ($results as $result)
				@php $item = DB::table($result->table_name)->where('id', $result->id)->get() @endphp
				@foreach ($item as $key)
					<div class="search-result">
						@if ($key->table_name === 'categories')
							<h5>
								<a href="{{route('category_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</h5>
						@elseif ($key->table_name === 'subcategories')
							<div class="result-icon">
								<img class="img-fluid" src="/storage/icons/{{$key->icon}}" />
							</div>
							<h5>
								<a href="{{route('subcategory_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</h5>
						@elseif ($key->table_name === 'threads')
							<h5>
								<a href="{{route('thread_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</h5>
						@elseif ($key->table_name === 'users')
							<div class="result-icon">
								<img class="img-fluid" src="{{$key->avatar}}" />
							</div>
							<div class="result-user">
								<h5>
									<a href="{{route('user_show', [$key->id])}}">{{ $key->username }}</a>
									<span class="{{role_coloring($key->role)}}">{{ ucfirst($key->role) }}</span>
								</h5>
							</div>
						@elseif ($key->table_name === 'posts')
							@php $thread = App\Post::find($key->id)->thread @endphp
							<h5>
								<a href="{{
									route('post_show', [
										$thread->id,
										$thread->slug,
										get_item_page_number($thread->posts->sortBy('created_at'), $key->id, settings_get('posts_per_page')),
										$key->id,
									])
								}}">
									{{ shorten_text($key->content) }}
								</a>
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