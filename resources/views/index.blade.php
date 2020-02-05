@extends('layouts.head')

@section('content')
	<table class="table">
		<thead>
			<tr class="table-header bg-pink">
				<th class="py-3">{{ __('Forum section') }}</th>
				<th class="py-3">{{ __('Latest post') }}</th>
				<th class="py-3">{{ __('Threads') }}</th>
				<th class="py-3">{{ __('Posts') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($tableCategories as $tableCategory)
				<tr class="table-category bg-dark">
					<th class="color-white">
						<a href="{{route('tablecategory_show', [$tableCategory->title, $tableCategory->id])}}">{{ __($tableCategory->title) }}</a>
					</th>
					<th></th> <th></th> <th></th> <!-- to make sure the row is full width, because tables -->
				</tr>
				@foreach ($tableCategory->tableSubcategories as $tableSubcategory)
					<tr>
						<td>
							<a href="
								{{route('tablesubcategory_show', [$tableSubcategory->title, $tableSubcategory->id])}}
							">{{ $tableSubcategory->title }}</a>
						</td>
						
						<td>
							@if (count($tableSubcategory->threads))
								<?php
									foreach ($tableSubcategory->threads as $thread) {
										$postAmount = count($thread->posts);
										foreach ($thread->posts->sortBy('created_at')->take(1) as $p) {
											$post = $p;
										}
									}
								?>
								<p>
									<a href="{{route('post_show', [$post->thread->title, $post->thread->id, $post->id])}}">{{ $post->thread->title }}</a>
								</p>
								<p class="post-created-by">
									<span>{{ __('By ') }}</span>
									<a href="{{route('user_show', [$thread->user->id])}}"> {{ $post->user->username }}</a>
									<span>{{ $post->created_at }}</span>
								</p>
							@endif
						</td>
						<td>{{ count($tableSubcategory->threads) }}</td>
						<td>{{ $postAmount ?? 0 }}</td>
						<?php unset($postAmount); ?>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
@endsection