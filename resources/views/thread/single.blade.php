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

	<div class="thread-title bg-dark">
		<div class="d-flex flex-row">
			@if (is_role('superadmin'))
				<a class="btn mr-2 spin btn-warning" href="{{route('thread_edit', [$thread->id, $thread->slug])}}">
					<i class="fas color-black fa-pen"></i>
				</a>
				<form action="{{route('thread_delete', [$thread->id, $thread->slug])}}" method="post">
					@csrf
					<input type="hidden" name="_method" value="DELETE">
					<button class="btn mr-2 spin btn-danger" href="{{route('thread_delete', [$thread->id, $thread->slug])}}" type="submit">
						<i class="fas color-white fa-trash-alt"></i>
					</button>
				</form>
			@endif
			<h5 class="text-white my-auto">{{ $thread->title }}</h5>
		</div>
	</div>

	<div class="thread">
		@foreach ($posts as $post)
			@component('components.post', ['post' => $post])
				
			@endcomponent
		@endforeach
	</div>

	@auth
		<div class="w-50 mx-auto my-2 bg-light" id="quick-reply">
			<form action="{{route('post_store', [$thread->id, $thread->slug])}}" method="POST">
				@csrf
				<textarea type="text" name="content" id="form-content"></textarea>
				<button class="btn spin btn-success m-2" type="submit">{{ __('Send') }}</button>
				<a class="btn spin btn-success my-2" href="#">
					{{ __('Preview') }}
				</a>
			</form>
		</div>
		<a class="btn spin mt-4 btn-success" href="{{route('post_create', [$thread->id, $thread->slug])}}">
			{{ __('Reply') }}
		</a>
	@endauth

	{{ $posts->links() }}
@endsection