{{-- Passed variables: $tableCategories --}}
@extends('head')

@section('pageTitle')
	{{ __('The pioneer hangout') }}
@endsection

@section('content')
	<div class="index" id="table">
		@auth
			@if (count(auth()->user()->visited_threads))
				@foreach (auth()->user()->visited_threads as $visited_thread)
					@php $visitedThreadsIds[] = $visited_thread->thread->id @endphp
				@endforeach
			@else
				@php $visitedThreadsIds = [] @endphp
			@endif
		@endauth

		@foreach ($tableCategories as $category)
			<div class="table-group" id="category-{{$category->id}}">
				@component('components.table-header', ['collapsible' => true])
					@slot('title')
						<a href="{{route('category_show', [$category->id, $category->slug])}}">
							{{ $category->title }}
						</a>
					@endslot
				@endcomponent

				<div class="subcategory-rows">
					@foreach ($category->subcategories as $subcategory)
						@php $subcategoryThreads = $subcategory->threads @endphp
						@if (count($posts = $subcategory->posts))
							@php $latest_posts = $posts->sortByDesc('created_at')->take(1) @endphp
							@foreach ($latest_posts as $latest_post)
							@endforeach
							@auth
								{{-- Check if user has any read thread in the subcategory --}}
								@php $read = true @endphp
								@foreach ($subcategoryThreads as $thread)
									@if (!in_array($thread->id, $visitedThreadsIds))
										@php $read = false @endphp
									@else
										@php $visited = auth()->user()->visited_threads->where('thread_id', $latest_post->thread->id) @endphp
										@foreach ($visited as $item)
											@if (strtotime($item->updated_at) - strtotime($latest_post->created_at) <= 0)
												@php $read = false @endphp
												@break
											@endif
										@endforeach
									@endif
								@endforeach
							@endauth
						@endif

						@component('components.table-row', ['read' => $read ?? null])
							@isset($subcategory->icon)
								@slot('icon')
									{{ $subcategory->icon }}
								@endslot
							@endisset

							@slot('title')
								<a href="{{route('subcategory_show', [$subcategory->id, $subcategory->slug])}}">
									{{ $subcategory->title }}
								</a>
							@endslot

							@slot('views')
								@php $views = 0; @endphp
								@foreach ($subcategoryThreads as $thread)
									@php $views += $thread->views @endphp
								@endforeach
								{{ $views }}
							@endslot

							@slot('posts')
								{{ count($posts) }}
							@endslot

							@slot('latest_post')
								@isset($latest_post->thread)
									<a class="posted-at" href="{{
										route('post_show', [
											$latest_post->thread->id,
											$latest_post->thread->slug,
											get_item_page_number(
												$latest_post->thread->posts->sortBy('created_at'),
												$latest_post->id,
												settings_get('posts_per_page')
											),
											$latest_post->id,
										])
									}}">
										{{ pretty_date($latest_post->updated_at) }}
										<i class="fas fa-sign-in-alt"></i>
									</a>
									<p>
										@isset($latest_post->user->username)
											<span>{{ __('By') }}</span>
										@endisset
										<a class="posted-by {{role_coloring($latest_post->user->role)}}" href="{{route('user_show', [$latest_post->user->id])}}">
											{{ $latest_post->user->username }}
										</a>
									</p>
								@endisset
							@endslot
						@endcomponent
					@endforeach {{-- $subcategories --}}
				</div>
			</div>
		@endforeach {{-- $tableCategories --}}
		
		@can('create', App\Category::class)
			@component('modals.crud', ['route_name' => 'category_store'])
				@slot('title')
					{{ __('Create new category') }}
				@endslot
				@slot('submit')
					{{ __('Create') }}
				@endslot
			@endcomponent
			<a class="btn btn-success-full" id="create-button" data-toggle="modal" href="#crudModal">
				<span>{{ __('Create new category') }}</span>
			</a>
		@endcan
	</div>
@endsection