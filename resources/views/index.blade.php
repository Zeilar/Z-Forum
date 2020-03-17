{{-- Passed variables: $tableCategories --}}
@extends('layouts.head')

@section('content')
	<div id="table">
		@foreach ($tableCategories as $tableCategory)
			@component('components.table-header')
				@slot('title')
					<a href="{{route('tablecategory_show', [$tableCategory->id, $tableCategory->slug])}}">
						{{ $tableCategory->title }}
					</a>
				@endslot
			@endcomponent

			@foreach ($tableCategory->tableSubcategories as $tableSubcategory)	
				@component('components.table-row')
					@slot('title')
						<a href="{{route('tablesubcategory_show', [$tableSubcategory->id, $tableSubcategory->slug])}}">
							{{ $tableSubcategory->title }}
						</a>
					@endslot

					@foreach ($tableSubcategory->posts as $post)
						@if ($post->user->role === 'superadmin')
							@slot('admin_post')
							@endslot

							@break
						@endif
					@endforeach

					@slot('views')
						<?php $views = 0; ?>
						@foreach ($tableSubcategory->threads as $thread)
							<?php $views += $thread->views ?>
						@endforeach
						{{ $views }}
					@endslot

					@slot('posts')
						{{ count($tableSubcategory->posts) }}
					@endslot

					@slot('latest_post')
						@foreach ($tableSubcategory->posts()->latest()->get() as $post)
							<a href="{{route('post_show', [$post->thread->id, $post->thread->slug, $post->id])}}">
								{{ pretty_date($post->updated_at) }}
								<i class="fas fa-sign-in-alt"></i>
							</a>
							@break {{-- Since we're in another loop, make sure we only do this one once no matter what --}}
						@endforeach
					@endslot
				@endcomponent
			@endforeach {{-- $tableSubcategories --}}
		@endforeach {{-- $tableCategories --}}
	</div>
	@if (is_role('superadmin'))
		@component('modals.crud', ['route_name' => 'tablecategory_store'])
			@slot('title')
				{{ __('Create new category') }}
			@endslot
			@slot('submit')
				{{ __('Create') }}
			@endslot
		@endcomponent
		<a class="btn btn-success" id="create-button" data-toggle="modal" href="#crudModal">
			<span>{{ __('Create new category') }}</span>
		</a>
	@endif
@endsection