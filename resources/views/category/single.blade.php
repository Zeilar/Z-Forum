{{-- Passed variables: $category --}}
@extends('layouts.head')

@section('pageTitle')
	{{ $category->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('category', $category) }}
@endsection

@section('content')
	<div id="table">
		<div class="table-group">
			@component('components.table-header')
				@slot('title')
					{{ $category->title }}
				@endslot
			@endcomponent

			@foreach ($category->subcategories as $subcategory)	
				@component('components.table-row')
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
			@endforeach {{-- $subcategory --}}
		</div>
	</div>

	@can('create', App\Subcategory::class)
		@component('modals.crud', ['route_name' => 'subcategory_store', 'route_values' => [$category->id, $category->slug]])
			@slot('title')
				{{ __('Create new subcategory') }}
			@endslot
			@slot('submit')
				{{ __('Create') }}
			@endslot
		@endcomponent

		<a class="btn btn-success" id="create-button" data-toggle="modal" href="#crudModal">
			<span>{{ __('Create new subcategory') }}</span>
		</a>
	@endcan
@endsection