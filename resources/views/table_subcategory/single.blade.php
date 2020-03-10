{{-- Passed variables: $tableSubcategory --}}
@extends('layouts.head')

@section('content')
	{{ Breadcrumbs::render('table_subcategory', $tableSubcategory) }}

	<div id="table">
		@component('components.table-header')
			@slot('title')
				{{ $tableSubcategory->title }}
			@endslot
		@endcomponent

		@foreach ($tableSubcategory->threads as $thread)	
			@component('components.table-row')
				@slot('title')
					<a href="{{route('thread_show', [$thread->id, $thread->slug])}}">
						{{ $thread->title }}
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
					{{ count($thread->posts) }}
				@endslot

				@slot('latest_post')
					@foreach ($thread->posts()->latest()->get() as $post)
						{{ pretty_date($post->updated_at) }}
						@break {{-- Since we're in another loop, make sure we only do this one once no matter what --}}
					@endforeach
				@endslot
			@endcomponent
		@endforeach {{-- $threads --}}
	</div>
@endsection