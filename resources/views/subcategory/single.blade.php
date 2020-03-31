{{-- Passed variables: $subcategory --}}
@extends('layouts.head')

@section('pageTitle')
	{{ $subcategory->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('subcategory', $subcategory) }}
@endsection

@section('content')
	<div id="table">
		<div class="table-group">
			@component('components.table-header')
				@slot('title')
					{{ $subcategory->title }}
				@endslot
			@endcomponent

			@foreach ($subcategory->threads as $thread)	
				{{-- Check if the thread has any admin post --}}
				@foreach ($subcategory->posts as $post)
					@if ($post->user->role === 'superadmin')
						@php $admin_post = true @endphp
						@break
					@endif
				@endforeach

				@auth
					{{-- Check if user has read the current thread --}}
					@foreach (auth()->user()->visited_threads as $visited_thread)
						@if ($visited_thread->thread->id === $thread->id)
							@php $read = true @endphp
						@endif
					@endforeach
				@endauth

				@component('components.table-row', ['admin_post' => $admin_post ?? null, 'read' => true ?? null])
					@slot('title')
						<a href="{{route('thread_show', [$thread->id, $thread->slug])}}">
							{{ $thread->excerpt }}
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
						{{ count($thread->posts) }}
					@endslot

					@slot('latest_post')
						@foreach ($thread->posts()->latest()->get() as $post)
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
			@endforeach {{-- $threads --}}
		</div>
	</div>
	
	<a class="btn btn-success-full" href="{{route('thread_create', [$subcategory->id, $subcategory->slug])}}">
		<span>{{ __('Create new thread') }}</span>
	</a>
@endsection