@extends('layouts.head')

@section('content')
	@component('components.breadcrumbs', ['position' => $tableSubcategory])
		
	@endcomponent

	<div class="table-wrapper">
		<table class="table">
			<thead>
				<tr class="table-subcategory">
					<th>
						<h5 class="text-white">{{ __($tableSubcategory->title) }}</h5>
					</th>
					<th></th> <th class="posts"></th> <!-- to make sure the row is full width, because tables -->
				</tr>
				<tr class="table-header">
					<th class="py-3"><h4>{{ __('Thread') }}</h4></th>
					<th class="py-3"><h4>{{ __('Latest post') }}</h4></th>
					<th class="py-3 text-center"><h4>{{ __('Posts') }}</h4></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($tableSubcategory->threads as $thread)
					<tr class="table-row">
						<td>
							<div class="d-flex">
								<div class="d-flex">
									<i class="fas fa-clipboard fa-2x my-auto mr-2"></i>
								</div>
								<div class="d-flex flex-column">
									<a class="thread-link" href="{{route('thread_show', [$thread->id, $thread->slug])}}">{{ __($thread->title) }}</a>
									<div>
										<span>{{ __('By') }}</span>
										<a class="thread-author-link" href="{{route('user_show', [$thread->user->username])}}">{{ $thread->user->username }}</a>
									</div>
								</div>
							</div>
						</td>
						<td>
							<!-- latest post -->
							@foreach ($thread->posts->sortByDesc('updated_at')->take(1) as $post)
								<p>
									<a href="{{route('post_show', [$post->thread->id, $post->thread->slug, $post->id])}}">{{ $post->thread->title }}</a>
								</p>
								<p class="post-created-by">
									<span>{{ __('By') }}</span>
									<a href="{{route('user_show', [$post->user->username])}}"> {{ $post->user->username }}</a>
									{{ pretty_date($post->updated_at) }}
								</p>
							@endforeach
						</td> 
						<td class="text-center">{{ count($thread->posts) }}</td> <!-- posts -->
					</tr>
				@endforeach
			</tbody>
		</table>
		<a class="d-flex mt-1 justify-content-end" href="{{route('tablesubcategory_create', [$tableSubcategory->id, $tableSubcategory->slug])}}">
			<button class="btn btn-success">{{ __('New subcategory') }}</button>
		</a>
	</div>
@endsection