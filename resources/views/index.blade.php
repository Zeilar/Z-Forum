{{-- Passed variables: $tableCategories --}}
@extends('layouts.head')

@section('pageTitle')
	{{ __('The pioneer hangout') }}
@endsection

@section('content')
	<div id="table">
		@foreach ($tableCategories as $category)
			<div class="table-group">
				@component('components.table-header')
					@slot('title')
						<a href="{{route('category_show', [$category->id, $category->slug])}}">
							{{ $category->title }}
						</a>
					@endslot
				@endcomponent

				@foreach ($category->subcategories as $subcategory)
					@auth
						{{-- Check if user has any read thread in the subcategory --}}
						@php $read = false @endphp

						@foreach ($subcategory->threads as $thread)
						@endforeach

						@foreach (auth()->user()->visited_threads as $visited_thread)
							@if ($visited_thread->thread->id === $thread->id)
								@php $read = true @endphp
							@endif
						@endforeach
					@endauth

					@component('components.table-row', ['read' => $read ?? null])
						@slot('title')
							<a href="{{route('subcategory_show', [$subcategory->id, $subcategory->slug])}}">
								{{ $subcategory->title }}
							</a>
						@endslot

						@slot('views')
							@php $views = 0; @endphp
							@foreach ($subcategory->threads as $thread)
								@php $views += $thread->views @endphp
							@endforeach
							{{ $views }}
						@endslot

						@slot('posts')
							{{ count($subcategory->posts) }}
						@endslot

						@slot('latest_post')
							@foreach ($subcategory->posts()->latest()->get() as $post)
								@isset($post->thread)
									<a href="{{
										route('post_show', [
											$post->thread->id,
											$post->thread->slug,
											get_item_page_number($post->thread->posts->sortBy('created_at'), $post->id, settings_get('posts_per_page')),
											$post->id,
										])
									}}">
										{{ pretty_date($post->updated_at) }}
										<i class="fas fa-sign-in-alt"></i>
									</a>
									@break {{-- Since we're in another loop, make sure we only do this one once no matter what --}}
								@endisset
							@endforeach
						@endslot
					@endcomponent
				@endforeach {{-- $subcategories --}}
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