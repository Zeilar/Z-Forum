@extends('layouts.app')

@section('content')
	<table class="table">
		<thead>
			<tr class="table-header bg-pink">
				<th class="py-3"><h4>{{ __('Title') }}</h4></th>
				<th class="py-3"><h4>{{ __('Latest post') }}</h4></th>
				<th class="py-3"><h4>{{ __('Posts') }}</h4></th>
			</tr>
		</thead>
		<tbody>
			<tr class="table-category bg-dark">
				<th><h5>{{ __($subcategory->title) }}</h5></th>
				<th></th><th></th> <!-- to make sure the row is full width, becaues tables -->
			</tr>
			@foreach ($subcategory->threads as $thread)
				<tr>
					<td>
						<a class="thread-link d-flex" href="/thread/{{$thread->title}}-{{$thread->id}}">{{ __($thread->title) }}</a>
						<p>
							<span>{{ __('By ') }}</span>
							<a class="thread-author-link" href="#">{{ $thread->user->username }}</a>
						</p>
					</td>
					<td>
						<!-- latest post -->
						@foreach ($thread->posts->sortByDesc('created_at')->take(1) as $post)
							<p class="post-created-at">{{ $post->created_at }}</p>
							<p class="post-created-by">{{ __('By ') }}<a href="#">{{ $post->user->username }}</a></p>
						@endforeach
					</td> 
					<td>{{ count($thread->posts) }}</td> <!-- posts -->
				</tr>
			@endforeach
		</tbody>
	</table>
	<a href="{{url()->current()}}/new">New</a>
@endsection