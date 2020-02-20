{{-- Passed variables: $tableCategory --}}
@extends('layouts.head')

@section('content')
	@component('components.breadcrumbs', ['position' => $tableCategory])
		
	@endcomponent

	<div class="table-wrapper">
		<table class="table">
			<thead>
				<tr class="table-category">
					<th><h5 class="text-white">{{ __($tableCategory->title) }}</h5></th>
					<th></th> <th class="threads"></th> <th class="posts"></th> <!-- to make sure the row is full width, because tables -->
				</tr>
				<tr class="table-header">
					<th class="py-3"><h4>{{ __('Subcategory') }}</h4></th>
					<th class="py-3"><h4>{{ __('Latest post') }}</h4></th>
					<th class="py-3"><h4 class="text-center">{{ __('Threads') }}</h4></th>
					<th class="py-3"><h4 class="text-center">{{ __('Posts') }}</h4></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($tableCategory->tableSubcategories as $tableSubcategory)
					<tr class="table-row">
						<td>
							<div class="d-flex">
								<i class="fas fa-folder-open mr-2"></i>
								<a class="subcategory-link" href="{{route('tablesubcategory_show', [$tableSubcategory->id, $tableSubcategory->slug])}}">
									{{ __($tableSubcategory->title) }}
								</a>
							</div>
						</td>
						<td>
							{{-- Latest Post --}}
							@foreach ($tableSubcategory->threads as $thread)
								@foreach ($thread->posts->sortByDesc('updated_at')->take(1) as $post)
								@endforeach
							@endforeach
							<p>
								<a href="{{route('post_show', [$post->thread->id, $post->thread->slug, $post->id])}}">{{ $post->thread->title }}</a>
							</p>
							<p class="post-created-by">
								<span>{{ __('By') }}</span>
								<a href="{{route('user_show', [$post->user->username])}}"> {{ $post->user->username }}</a>
								{{ pretty_date($post->updated_at) }}
							</p>
						</td> 
						<td class="text-center">{{ count($tableSubcategory->threads) }}</td>
						<td class="text-center">
							@if (count($thread->posts))
								{{ count($thread->posts) }}
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<a class="btn spin btn-success" href="{{route('tablecategory_create')}}">{{ __('New category') }}</a>
	</div>
@endsection