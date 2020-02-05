@extends('layouts.app')

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
					<th class="color-white">{{ __($tableCategory->title) }}</th>
					<th></th><th></th><th></th> <!-- to make sure the row is full width, because tables -->
				</tr>
				@foreach ($tableCategory->tableSubcategories as $tableSubcategory)
					<tr>
						<td><a href="
							{{route('tablesubcategory_show', [$tableSubcategory->title, $tableSubcategory->id])}}
						">{{ $tableSubcategory->title }}</a></td>
						<?php
							if (count($tableSubcategory->threads)) {
								foreach ($tableSubcategory->threads as $thread) {
									$postAmount = count($thread->posts);
									foreach ($thread->posts->sortBy('created_at')->take(1) as $p) {
										$post = $p;
									}
								}
							}
						?>
						<td>
							@if (isset($post))
								<p class="post-created-at">{{ $post->created_at }}</p>
								<p class="post-created-by">{{ __('By ') }}<a href="{{route('user_show', [$post->user->id])}}">{{ $post->user->username }}</a></p>
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