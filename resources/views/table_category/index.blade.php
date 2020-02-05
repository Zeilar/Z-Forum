@extends('layouts.app')

@section('content')
	<p class="breadcrumb">
		<a href="/">{{ __('Home') }}</a> 
		<span class="mx-1">&raquo;</span>
		<a>{{ __($tableCategory->title) }}</a>
	</p>

	<table class="table">
		<thead>
			<tr class="table-header bg-pink">
				<th class="py-3"><h4>{{ __('Title') }}</h4></th>
				<th class="py-3"><h4>{{ __('Latest post') }}</h4></th>
				<th class="py-3"><h4>{{ __('Threads') }}</h4></th>
			</tr>
		</thead>
		<tbody>
			<tr class="table-category bg-dark">
				<th><h5>{{ __($tableCategory->title) }}</h5></th>
				<th></th><th></th> <!-- to make sure the row is full width, becaues tables -->
			</tr>
			@foreach ($tableCategory->tableSubcategories as $tableSubcategory)
				<tr>
					<td>
						<a class="thread-link" href="
							{{route('tablesubcategory_show', [$tableSubcategory->title, $tableSubcategory->id])}}
						">{{ __($tableSubcategory->title) }}</a>
					</td>
					<td>
						<!-- latest post -->
						@foreach ($tableSubcategory->threads->sortBy('created_at')->take(1) as $thread)
							<p class="thread-created-by">{{ __('By ') }}
								<a href="{{route('thread_show', [$thread->title, $thread->id])}}">{{ $thread->user->username }}</a>
								<span>{{ $thread->created_at }}</span>
							</p>
						@endforeach
					</td>
					<td>{{ count($tableSubcategory->threads) }}</td> <!-- threads -->
				</tr>
			@endforeach
		</tbody>
	</table>
	<a href="{{route('thread_create', [$tableCategory->title, $tableCategory->id])}}">New</a>
@endsection