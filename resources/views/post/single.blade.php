{{-- Passed variables: $post --}}
@extends('layouts.head')

@section('content')
	{{ Breadcrumbs::render('post', $post) }}

	@component('components.post', ['post' => $post])
		@slot('banner_link')
			<a href="{{route('post_show', [$post->thread->id, $post->thread->slug, $post->id])}}">
				{{ __('View in thread') }} &raquo;
			</a>
		@endslot
	@endcomponent

	@auth
		@if (is_role('superadmin', 'moderator') || $post->user->id === auth()->user()->id)
			<script>
				// Initalize post handlers on page load
				post_handlers();

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

				// Spawn the save button and Summernote editor on the post
				function post_edit(element) {
					element.parents('.post').find('.post-body').summernote();
					if (!element.parents('.post').find('.post-save-toolbar').length) {
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

				// Initialize post handlers in order to let them be "recursive"
				function post_handlers() {
					$('.post').each(function() {
						let original = $(this).html();
						$(this).find('.post-edit').click(function(e) {
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

						$(this).find('.post-delete').click(function(e) {
							post_delete($(this), e)
						});
					});
				}

				$('.post .post-delete').click(function(e) {
					post_delete($(this), e);
				});
			</script>
		@endif
	@endauth
@endsection