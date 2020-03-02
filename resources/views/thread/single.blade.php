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

	<div class="thread-title mt-4 mb-2 bg-dark">
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
				@slot('banner_link')
					<a href="{{route('post_permalink', [$post->id])}}">{{ __('Permalink') }} &raquo;</a>
				@endslot
			@endcomponent
		@endforeach
	</div>

	@auth
		<div class="w-50 mx-auto my-2 bg-light" id="quick-reply">
			<form action="{{route('post_store', [$thread->id, $thread->slug])}}" method="POST">
				@csrf
				<textarea type="text" name="content" id="form-content"></textarea>
				<button class="btn spin btn-success m-2" type="submit">{{ __('Send') }}</button>
				<button class="btn btn-success my-2 preview-button" type="button">
					{{ __('Preview') }}
				</button>
			</form>
		</div>
		<a class="btn spin mt-4 btn-success" href="{{route('post_create', [$thread->id, $thread->slug])}}">
			{{ __('Reply') }}
		</a>

		<script>
			$('.preview-button').click(function() {
				let content = $('.note-editable').html();
				let postFormat = `
					<article class="post is_author" id="preview">
						<div class="post-header row m-0 justify-content-between">
							<span class="post-date px-2 color-white">
								{{ __('Today,') }}
								{{ date('H:i') }}
							</span>
							<span class="post-thread px-2">
								<a>{{ __('Permalink') }} &raquo;</a>
							</span>
						</div>
						<div class="post-body d-flex flex-row">
							<div class="col p-2 user-meta">
								<p class="user-link">
									<a class="{{ role_coloring(auth()->user()->role) }}" href="#">
										{{ auth()->user()->username }}
									</a>
								</p>
								<p class="user-role">{{ __(ucfirst(auth()->user()->role)) }}</p>
								<div class="w-50">
									<img class="img-fluid py-2" src="/storage/user-avatars/{{auth()->user()->avatar}}" />
								</div>
								<p class="user-date">{{ __('Registered: ' . date('M Y', strtotime(auth()->user()->created_at))) }}</p>
							</div>
							<div class="col p-2 post-content">
								
							</div>
						</div>
					</article>
				`;

				if (!$('#preview').length) {
					$('.thread').append(postFormat);
				}
				$('#preview .post-content').html(content);
			});
		</script>
	@endauth

	{{ $posts->links() }}
@endsection