{{-- Passed variables: $subcategory --}}
@extends('layouts.head')

@section('content')
	{{ Breadcrumbs::render('subcategory', $subcategory) }}

	<div id="table">
		@component('components.table-header')
			@slot('title')
				{{ $subcategory->title }}
			@endslot
		@endcomponent

		@foreach ($subcategory->threads as $thread)	
			@component('components.table-row')
				@slot('title')
					<a href="{{route('thread_show', [$thread->id, $thread->slug])}}">
						{{ $thread->title }}
					</a>
				@endslot

				@foreach ($subcategory->posts as $post)
					@if ($post->user->role === 'superadmin')
						@slot('admin_post')
						@endslot

						@break
					@endif
				@endforeach

				@slot('views')
					<?php $views = 0; ?>
					@foreach ($subcategory->threads as $thread)
						<?php $views += $thread->views ?>
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
	<a class="btn btn-success spin" href="{{route('thread_create', [$subcategory->id, $subcategory->slug])}}">
		<span>{{ __('Create new thread') }}</span>
	</a>
@endsection