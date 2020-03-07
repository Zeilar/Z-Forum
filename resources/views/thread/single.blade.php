{{-- Passed variables: $thread --}}
@extends('layouts.head')

@section('content')
	@component('components.breadcrumbs', ['position' => $thread])
		
	@endcomponent

	@component('components.summernote', [
		'placeholder' => 'Quick reply',
		'height'	  => 150,
	])

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
			<div class="mx-auto my-2 bg-light" id="quick-reply">
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

					if (!$('#preview').length) {
						$('.thread').append(`
							@component('components.post', ['post' => 'preview'])

							@endcomponent
						`);
					}
					$('#preview .post-body').html(content);
				});
			</script>
		@endif
	@endauth

	{{ $posts->links('layouts.pagination') }}
@endsection