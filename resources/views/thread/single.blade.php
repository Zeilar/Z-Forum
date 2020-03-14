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

	<div class="thread-toolbar d-flex flex-row">
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
	</div>
	<h5 class="thread-title">{{ $thread->title }}</h5>

	<div class="thread">
		<?php $i = ($posts->currentPage() - 1) * $posts->perPage() + 1; ?>
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

					// '<p><br></p>' is Summernote default for empty, if the editor is empty, do nothing
					if (content === '<p><br></p>') return;
					
					// Only render the preview if it doesn't already exist
					if (!$('#preview').length) {
						// Render the post itself, but not the content
						$('.thread').append(`@include('components.post', ['post' => 'preview'])`);
					}

					// Inject the content
					$('#preview .post-body').html(content);
				});
			</script>
		@endif

		<script>
			// Spawn the save button and Summernote editor on the post
			function post_edit(element) {
				element.parents('.post-toolbar').siblings('.post-body').summernote();
				if (!element.parent().siblings('.post-save-toolbar').length) {
					element.parents('.post-toolbar').append(`
						<div class="d-flex post-save-toolbar flex-row">
							<button class="btn btn-success spin post-save">
								Save
							</button>
						</div>
					`);
				}
			}

			// Save the edited post and reset elements to how they were before, but with the updated post content
			function post_save(element, original, e) {
				let id = element.parents('.post').attr('id');
				let content = element.parents('.post').find('.note-editable').html();
				e.preventDefault();
				$.ajax({
					url: '{{ route("post_update_ajax") }}',
					method: 'POST',
					data: {
						_token: '{{ Session::token() }}',
						id: id,
						content: content
					},
					success: function() {
						// Reset post element and remove Summernote editor
						$(`#${id}`).html(original);

						// Insert the newly edited content into the post
						$(`#${id} .post-body`).html(content);

						// The event handler needs to be re-initalized since the element was destroyed
						post_handlers();
					},
					error: function(error) {
						console.log(error);
					}
				});
			}

			// Initialize post handlers in order to let them be "recursive"
			function post_handlers() {
				$('.post-edit').each(function() {
					let original = $(this).parents('.post').html();
					$(this).click(function(e) {
						post_edit($(this));

						$(this).parent().siblings().children('.post-save').click(function(e) {
							post_save($(this), original, e);
						});
					});
				}) 
			}

			// Initalize post handlers on page load
			post_handlers();
		</script>
	@endauth

	{{ $posts->links('layouts.pagination') }}
@endsection