@extends('head')

@section('pageTitle')
	{{ __('Search') . ' | ' . request('query') }}
@endsection

@section('content')
	<div class="search-results">
		@if (count($results))
			<h2>{{ __('Search results for: ') . request('query') }}</h2>
			@foreach ($results as $result)
				@php $item = DB::table($result->table_name)->where('id', $result->id)->get() @endphp
				@foreach ($item as $key)
					<div class="search-result">
						@if ($key->table_name === 'categories')
							<div class="result-source">
								<p>
									{{ __('Category') }}
								</p>
							</div>
							<div class="result-content">
								<a href="{{route('category_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</div>
						@elseif ($key->table_name === 'subcategories')
							@php $subcategory = App\Subcategory::find($key->id) @endphp
							<div class="result-source">
								<p>
									{{ __('Subcategory in ') }}
									<a href="{{route('category_show', [$subcategory->category->id, $subcategory->category->slug])}}">
										{{ $subcategory->category->title }}
									</a>
								</p>
							</div>
							<div class="result-content">
								<div class="result-icon">
									<img class="img-fluid" src="/storage/icons/{{$key->icon}}" />
								</div>
								<a href="{{route('subcategory_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</div>
						@elseif ($key->table_name === 'threads')
							@php $thread = App\Thread::find($key->id) @endphp
							<div class="result-source">
								<p>
									{{ __('Thread in ') }}
									<a href="{{route('subcategory_show', [$thread->subcategory->id, $thread->subcategory->slug])}}">
										{{ $thread->subcategory->title }}
									</a>
								</p>
							</div>
							<div class="result-content">
								<a href="{{route('thread_show', [$key->id, $key->slug])}}">{{ $key->title }}</a>
							</div>
						@elseif ($key->table_name === 'users')
							<div class="result-source">
								<p>{{ __('User') }}</p>
							</div>
							<div class="result-content">
								<div class="result-icon">
									<img class="img-fluid" src="{{$key->avatar}}" />
								</div>
								<div class="result-user">
									<div class="result-user-text">
										<a href="{{route('user_show', [$key->id])}}">{{ $key->username }}</a>
										<span class="{{role_coloring($key->role)}}">{{ ucfirst($key->role) }}</span>
									</div>
								</div>
							</div>
						@elseif ($key->table_name === 'posts')
							@php $thread = App\Post::find($key->id)->thread @endphp
							<div class="result-source">
								<p>
									{{ __('Posted in ') }}
									<a href="{{route('thread_show', [$thread->id, $thread->slug])}}">
										{{ shorten_text($thread->title, 80) }}
									</a>
									<span class="posted-by">
										{{ __('By ') }}
										<a class="{{role_coloring($thread->user->role)}}" href="{{route('user_show', [$thread->user->id])}}">
											{{ $thread->user->username }}
										</a>
									</span>
								</p>
							</div>
							<div class="result-content">
								<p>
									{!! shorten_text($key->content, 300) !!}
									<p class="result-read-more">
										<a class="read-more-button" href="{{
											route('post_show', [
												$thread->id,
												$thread->slug,
												get_item_page_number($thread->posts->sortBy('created_at'), $key->id, settings_get('posts_per_page')),
												$key->id,
											])
										}}">
											{{ __(' Read more') }} &raquo;
										</a>
									</p>
								</p>
							</div>
						@endif
					</div>
				@endforeach
			@endforeach
		@else
			<h2>{{ __('No results were found for: ') . request('query') }}</h2>
		@endif
	</div>
	
	{{ $results->appends(request()->query())->links('layouts.pagination') }}
@endsection