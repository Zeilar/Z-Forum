@extends('layouts.head')

@section('content')
	<p class="breadcrumb">
		<a href="/">{{ __('Home') }}</a> 
		<span class="mx-1 d-flex"><i class="fas m-auto fa-angle-double-right"></i></span>
		<a href="
			{{route('tablecategory_show', [$tableSubcategory->tableCategory->title, $tableSubcategory->tableCategory->id])}}
		">{{ $tableSubcategory->tableCategory->title }}</a>
		<span class="mx-1 d-flex"><i class="fas m-auto fa-angle-double-right"></i></span>
		<span>{{ __($tableSubcategory->title) }}</span> 
	</p>

	<table class="table">
		<thead>
			<tr class="table-subcategory bg-dark">
				<th>
					<h5 class="text-white">{{ __($tableSubcategory->title) }}</h5>
				</th>
				<th></th> <th></th> <!-- to make sure the row is full width, because tables -->
			</tr>
			<tr class="table-header bg-green">
				<th class="py-3"><h4>{{ __('Thread') }}</h4></th>
				<th class="py-3"><h4>{{ __('Latest post') }}</h4></th>
				<th class="py-3 text-center"><h4>{{ __('Posts') }}</h4></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($tableSubcategory->threads as $thread)
				<tr>
					<td>
						<div class="d-flex">
							<div class="d-flex">
								<i class="fas fa-clipboard fa-2x my-auto mr-2"></i>
							</div>
							<div class="d-flex flex-column">
								<a class="thread-link" href="{{route('thread_show', [$thread->title, $thread->id])}}">{{ __($thread->title) }}</a>
								<div>
									<span>{{ __('By') }}</span>
									<a class="thread-author-link" href="{{route('user_show', [$thread->user->username])}}">{{ $thread->user->username }}</a>
								</div>
							</div>
						</div>
					</td>
					<td>
						<!-- latest post -->
						@foreach ($thread->posts->sortByDesc('created_at')->take(1) as $post)
							<p>
								<a href="{{route('post_show', [$post->thread->title, $post->thread->id, $post->id])}}">{{ $post->thread->title }}</a>
							</p>
							<p class="post-created-by">
								<span>{{ __('By') }}</span>
								<a href="{{route('user_show', [$post->user->username])}}"> {{ $post->user->username }}</a>
								{{ pretty_date($post->created_at) }}
							</p>
						@endforeach
					</td> 
					<td class="text-center">{{ count($thread->posts) }}</td> <!-- posts -->
				</tr>
			@endforeach
		</tbody>
	</table>
	<a href="{{route('thread_create', [$tableSubcategory->title, $tableSubcategory->id])}}">New</a>
@endsection