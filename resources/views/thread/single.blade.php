{{-- Passed variables: $thread --}}
@extends('layouts.head')

@section('content')
	{{ Breadcrumbs::render('thread', $thread) }}

	@component('components.summernote')
		@slot('placeholder')
			Quick reply
		@endslot
		@slot('height')
			150
		@endslot
	@endcomponent

	<div class="thread-title">
		<div class="d-flex flex-row">
			@if (is_role('superadmin', 'moderator'))
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
				@if ($thread->locked)
					<form action="{{route('thread_unlock', [$thread->id, $thread->slug])}}" method="post">
						@csrf
						<input type="hidden" name="_method" value="PUT">
						<button class="btn mr-2 spin btn-secondary" href="{{route('thread_unlock', [$thread->id, $thread->slug])}}" type="submit">
							<i class="fas color-white fa-unlock"></i>
						</button>
					</form>
				@else
					<form action="{{route('thread_lock', [$thread->id, $thread->slug])}}" method="post">
						@csrf
						<input type="hidden" name="_method" value="PUT">
						<button class="btn mr-2 spin btn-secondary" href="{{route('thread_lock', [$thread->id, $thread->slug])}}" type="submit">
							<i class="fas color-white fa-lock"></i>
						</button>
					</form>
				@endif
			@endif
			<h5 class="text-white my-auto">{{ $thread->title }}</h5>
		</div>
	</div>

	<div class="thread">
		<?php $i = 1; ?>
		@foreach ($posts as $post)
			@component('components.post', ['post' => $post, 'i' => $i])

			@endcomponent
			<?php $i++; ?>
		@endforeach
	</div>

	@auth
		@if (!$thread->locked || is_role('superadmin', 'moderator'))
			<div id="quick-reply">
				<form action="{{route('post_store', [$thread->id, $thread->slug])}}" method="POST">
					@csrf
					<textarea type="text" name="content" id="form-content"></textarea>
					<button class="btn spin btn-success my-2 mr-2" type="submit">{{ __('Send') }}</button>
					<button class="btn btn-success my-2 preview-button" type="button">
						{{ __('Preview') }}
					</button>
				</form>
			</div>

			<script>
				// Render post preview
				$('.preview-button').click(function() {
					// Prepare the user input in the editor
					let content = $('.note-editable').html();
					
					// Only render the preview if it doesn't already exist and isn't "empty"
					// Summernote always renders '<p><br></p>' by default no matter what
					if (!$('#preview').length && content !== '<p><br></p>') {
						// Render the post itself, but not the content
						$('.thread').append(`
							@component('components.post', ['post' => 'preview'])

							@endcomponent
						`);

						// Inject the content
						$('#preview .post-body').html(content);
					}
				});
			</script>
		@endif
	@endauth

	{{ $posts->links('layouts.pagination') }}
@endsection