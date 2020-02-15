@extends('layouts.head')

@section('content')
	@component('components.breadcrumbs', ['position' => $thread])
		
	@endcomponent

	<div class="thread-title bg-dark mb-3">
		<h5 class="text-white">{{ $thread->title }}</h5>
	</div>

	<div class="thread">
		@foreach ($posts as $post)
			@component('components.post', ['post' => $post])
				
			@endcomponent
		@endforeach
	</div>
	@auth
		<form class="quick-reply" action="{{route('post_store', [$thread->title, $thread->id])}}" method="POST">
			@csrf
			<textarea name="content" id="form-content"></textarea>
			<button class="btn btn-success" type="submit">{{ __('Send') }}</button>
		</form>
		<a href="{{route('post_create', [$thread->title, $thread->id])}}">
			<button class="btn mt-4 btn-success color-white" type="button">{{ __('Reply') }}</button>
		</a>
	@endauth

	{{ $posts->links() }}
@endsection