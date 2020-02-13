@extends('layouts.head')

@section('content')
	<p class="breadcrumb">
		<a href="/">{{ __('Home') }}</a> 
		<span class="mx-1">&raquo;</span>
		<a>{{ __($tableCategory->title) }}</a>
	</p>

	<table class="table">
		<thead>
			<tr class="table-category bg-dark">
				<th><h5 class="text-white">{{ __($tableCategory->title) }}</h5></th>
				<th></th ><th></th> <th></th> <!-- to make sure the row is full width, because tables -->
			</tr>
			<tr class="table-header bg-green">
				<th class="py-3"><h4>{{ __('Subcategory') }}</h4></th>
				<th class="py-3"><h4>{{ __('Latest post') }}</h4></th>
				<th class="py-3"><h4 class="text-center">{{ __('Threads') }}</h4></th>
				<th class="py-3"><h4 class="text-center">{{ __('Posts') }}</h4></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($tableCategory->tableSubcategories as $tableSubcategory)
				@foreach ($tableSubcategory->threads as $thread)
					<tr>
						<td>
							<div class="d-flex">
								<i class="fas fa-folder-open mr-2"></i>
								<a class="subcategory-link" href="{{route('tablesubcategory_show', [$tableSubcategory->title, $tableSubcategory->id])}}">
									{{ __($tableSubcategory->title) }}
								</a>
							</div>
						</td>
						<td>
							<!-- latest post -->
							@foreach ($thread->posts->sortBy('created_at')->take(1) as $post)
								<p>
									<a href="{{route('post_show', [$post->thread->title, $post->thread->id, $post->id])}}">{{ $post->thread->title }}</a>
								</p>
								<p class="post-created-by">
									<span>{{ __('By') }}</span>
									<a href="{{route('user_show', [$thread->user->id])}}"> {{ $post->user->username }}</a>
									<span>{{ date_comma($post->created_at) }}</span>
								</p>
							@endforeach
						</td> 
						<td class="text-center">{{ count($tableSubcategory->threads) }}</td>
						<td class="text-center">{{ count($thread->posts) }}</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
	<a href="{{route('tablesubcategory_create', [$tableCategory->title, $tableCategory->id])}}">New</a>
@endsection