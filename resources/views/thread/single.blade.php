{{-- Passed variables: $thread --}}
@extends('layouts.head')

@section('content')
	@component('components.breadcrumbs', ['position' => $thread])
		
	@endcomponent
	@component('components.summernote', [
		'placeholder' => 'Quick reply',
		'height'	  => 100,
	])
		
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
		<form class="quick-reply" action="{{route('post_store', [$thread->id, $thread->slug])}}" method="POST">
			@csrf
			<input type="text" name="content" id="form-content" />
			<button class="btn btn-success" type="submit">{{ __('Send') }}</button>
		</form>
		<a href="{{route('post_create', [$thread->id, $thread->slug])}}">
			<button class="btn mt-4 btn-success color-white" type="button">{{ __('Reply') }}</button>
		</a>
	@endauth

	{{ $posts->links() }}
@endsection