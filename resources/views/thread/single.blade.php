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
				<button class="btn mr-2 spin thread-toggle btn-secondary" type="button">
					<i class="fas color-white fa-unlock"></i>
				</button>
			@else
				<button class="btn mr-2 spin thread-toggle btn-secondary" type="button">
					<i class="fas color-white fa-lock"></i>
				</button>
			@endif
		@endif
	</div>
	<h5 class="thread-title">{{ $thread->title }}</h5>

	<div class="thread @if ($thread->locked) locked @endif">
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
					<button class="btn spin btn-success my-2 mr-2" type="submit" disabled>
						<span>{{ __('Send') }}</span>
					</button>
					<button class="btn btn-success my-2 preview-button" type="button" disabled>
						<span>{{ __('Preview') }}</span>
					</button>
				</form>
			</div>

			<script>
				let interval = setInterval(() => {
					if ($('#quick-reply .note-editable').length) clearInterval(interval);

					$('#quick-reply .note-editable').on('input', function() {
						if ($(this).html() !== '<p><br></p>' && $(this).html() !== '') {
							$('#quick-reply button').each(function() {
								$(this).removeAttr('disabled');
							});
						} else {
							$('#quick-reply button').each(function() {
								$(this).attr('disabled', true);
							});
						}
					})
				}, 50);

				// Render post preview
				$('.preview-button').click(function() {
					// Prepare the user input in the editor
					let content = $('.note-editable').html();

					// '<p><br></p>' is Summernote default for empty, if the editor is empty, do nothing
					if (content === '<p><br></p>' || content === '') return;
					
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

		@if (is_role('superadmin', 'moderator') || $post->user->id === auth()->user()->id)
			<script>
				// Spawn alert element on top of the site with message
				function ajax_alert(response) {
					let alertIcon = '';

					switch (response.type) {
						case 'success':
							alertIcon = '<i class="fas fa-check"></i>';
							break;
						case 'error':
							alertIcon = '<i class="fas fa-exclamation"></i>';
							break;
						case 'warning':
							alertIcon = '<i class="fas fa-exclamation-triangle"></i>';
							break;
					}

					let alertContent = `
						<div class="alert ${response.type}">
							${alertIcon}
							<span>${response.message}</span>
							<div>
								<i class="fas close fa-times"></i>
							</div>
						</div>
					`;

					if (!$('.alert').length) {
						$('#content').prepend(alertContent);
					} else {
						$('.alert').replaceWith(alertContent);
					}

					// Remove alert after a while regardless
					setTimeout(() => {
						// Do a fade animatin before removing
						$('.alert').addClass('fade-out');

						// Remove element after animation is finished, it needs to be the same amount as the animation duration on the element
						setTimeout(() => {
							$('.alert').remove();
						}, 500);
					}, 5000);

					// Remove alert when the X button is clicked
					$('.alert div').click(function() {
						$(this).parents('.alert').remove();
					});
				}

				// Initialize post handlers in order to let them be "recursive"
				function post_handlers() {
					$('.post-edit').each(function() {
						let original = $(this).parents('.post').html();
						$(this).click(function(e) {
							post_edit($(this));

							$(this).parents('.post').find('.post-save').click(function(e) {
								post_save($(this), original, e);
							});

							$(this).parents('.post').find('.post-cancel').click(function(e) {
								post_cancel($(this), original, e);
							});

							// Remove edit button after it's clicked
							$(this).parent().remove();
						});
					}) 
				}
				// Initalize post handlers on page load
				post_handlers();

				// Spawn the save button and Summernote editor on the post
				function post_edit(element) {
					element.parents('.post').find('.post-body').summernote();
					if (!element.parents('.post').find('.post-save-toolbar').length) {
						let toolbar = element.parents('.post-toolbar').html();
						element.parents('.post-toolbar').append(`
							<div class="post-save-toolbar">
								<button class="btn btn-success spin post-save">
									<span>Save</span>
								</button>
								<button class="btn btn-success spin post-cancel">
									<span>Cancel</span>
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
						success: function(response) {
							// Reset post element and remove Summernote editor
							$(`#${id}`).html(original);

							// Insert the newly edited content into the post
							$(`#${id} .post-body`).html(content);

							ajax_alert(response);

							// The event handler needs to be re-initalized since the element was destroyed
							post_handlers();
						},
						error: function(error) {
							console.log(error);
						}
					});
				}

				// Cancel the edited post and reset elements to how they were before
				function post_cancel(element, original, e) {
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

							// The event handler needs to be re-initalized since the element was destroyed
							post_handlers();
						},
						error: function(error) {
							console.log(error);
						}
					});
				}

				function post_delete(element, e) {
					let id = element.parents('.post').attr('id');
					e.preventDefault();
					$.ajax({
						url: '{{ route("post_delete_ajax") }}',
						method: 'POST',
						data: {
							_token: '{{ Session::token() }}',
							id: id,
						},
						success: function(response) {
							// If the post is the last of its thread, a redirect to the previous page will be supplied
							// Otherwise just remove the post element
							if (response.redirect) {
								window.location.href = response.redirect;
							} else {
								$(`#${id}`).remove();
								ajax_alert(response);
							}
						},
						error: function(error) {
							console.log(error);
						}
					});
				}

				$('.post .post-delete').click(function(e) {
					post_delete($(this), e);
				});

				$('.thread-toggle').click(function(e) {
					let url = '{{ route("thread_toggle") }}';
					let id = '{{ $thread->id }}';
					e.preventDefault();
					$.ajax({
						url: url,
						method: 'POST',
						data: {
							_token: '{{ Session::token() }}',
							id: id,
						},
						success: function(response) {
							ajax_alert(response);
							$('.thread-toggle').removeClass('loading').removeAttr('disabled');
							if (response.state === 'unlocked') {
								$('.thread-toggle i').removeClass('fa-lock').addClass('fa-lock color-white')
							} else {
								$('.thread-toggle i').removeClass('fa-lock').addClass('fa-unlock color-white');
							}
						},
						error: function(error) {
							console.log(error);
						}
					});
				});
			</script>
		@endif
	@endauth

	{{ $posts->links('layouts.pagination') }}
@endsection