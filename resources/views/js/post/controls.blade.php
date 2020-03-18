@auth
	@if (is_role('superadmin', 'moderator') || $post->user->id === auth()->user()->id)
		@include('js.post.alert')

		<script>
			// Initalize post handlers on page load
			post_handlers();

			// Spawn the save button and TinyMCE editor on the post
			function post_edit(element) {
				let selector = element.parents('.post').attr('id');

				tinymce.init({
					selector: `#${selector} .post-body`,
					plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
					toolbar_mode: 'floating',
				});

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

			// Cancel the edited post and reset elements to how they were before
			function post_cancel(element, original, e) {
				let id = element.parents('.post').attr('id');
				
				// Reset post element and remove TinyMCE editor
				$(`#${id}`).html(original);

				// The event handler needs to be re-initalized since the element was destroyed
				post_handlers();
			}

			// Save the edited post and reset elements to how they were before, but with the updated post content
			function post_save(element, original, e) {
				let id = element.parents('.post').attr('id');

				// Find TinyMCE content inside iframe
				let iframe = element.parents('.post').find('iframe')[0];
				let iframeWindow = iframe.contentWindow.document;
				let content = $(iframeWindow).find('body').html();

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
						// Reset post element and remove TinyMCE editor
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

			// Delete post
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