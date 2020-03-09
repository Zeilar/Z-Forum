{{-- Passed variables: $tableCategory --}}
@extends('layouts.head')

@section('content')
	@include('layouts.breadcrumbs', ['position' => $tableCategory])

	<div id="table">
		@component('components.table-header')
			@slot('title')
				{{ $tableCategory->title }}
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
					{{ 'N/A' }}
				@endslot

				@slot('posts')
					{{ count($tableSubcategory->posts) }}
				@endslot

				@slot('latest_post')
					@foreach ($tableSubcategory->posts()->latest()->get() as $post)
						{{ pretty_date($post->updated_at) }}
						@break {{-- Since we're in another loop, make sure we only do this one once no matter what --}}
					@endforeach
				@endslot
			@endcomponent
		@endforeach {{-- $tableSubcategory --}}
	</div>
@endsection