@auth
	@isset($post)
		@can('update', $post)
			@include('js.post.alert')

			<script>
				// Initalize post handlers on page load
				post_handlers();
				
				// Spawn the save button and TinyMCE editor on the post
				function post_edit(element) {
					let selector = element.parents('.post').attr('id');

					tinymce.init({
						selector: `#${selector} .post-body`,
						plugins: 'advlist autolink lists link image media charmap print preview hr anchor pagebreak bbcode code',
						height: 300,
					});

					// Since CSS can't style inside iframes, we do it here...
					let interval = setInterval(() => {
						if ($(`#${selector} iframe`).length) {
							// Find TinyMCE content inside iframe
							let iframe = $(`#${selector} iframe`)[0];
							let iframeWindow = iframe.contentWindow.document;

							// Style p elements inside to match the rest of the site
							$(iframeWindow).find('body p').css({
								'margin': '0.25rem 0',
								'line-height': '1.5',
							});

							// Spawn the edit message row
							if (!$(`#${selector}`).find('.post-edited-by').length) {
								$(`#${selector} .tox-tinymce`).after(`
									<div class="post-edited-by">
										<div class="edit-title">
											<span>Reason</span>
										</div>
										<input type="text" class="edit-message" />
									</div>
								`);
							} else {
								$(`#${selector} .post-edited-by`).html(`
									<div class="edit-title">
										<span>Reason</span>
									</div>
									<input type="text" class="edit-message" />
								`);
							}

							$(`#${selector} .edit-message`).focus();

							clearInterval(interval);
						}
					}, 50);

					let deleteButton = element.siblings('.post-delete');

					element.parents('.post').append(`
						<div class="post-toolbar">
							<button class="btn btn-success-full spin post-save">
								<span>Save</span>
							</button>
							<button class="btn btn-default post-cancel">
								<span>Cancel</span>
							</button>
						</div>
					`);

					if (deleteButton.length) element.parents('.post').find('.post-toolbar').append(deleteButton);
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
					let edit_message = element.parents('.post').find('.post-edited-by input').val();
					if (edit_message === '') edit_message = false;

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
							content: content,
							edit_message: edit_message
						},
						success: function(response) {
							// Reset post element and remove TinyMCE editor first
							$(`#${id}`).html(original);

							// If the user left an edit message, include it in the insertion
							let edit_message = '';
							if (response.edited_by_message !== null) {
								edit_message = `<p class="edited-message">"${response.edited_by_message}"</p>`;
							}

							// Insert the newly edited content into the post
							$(`#${id} .post-body`).html(response.content);
							if (response.edited_by) {
								if ($(`#${id} .post-edited-by`).length) {
									$(`#${id} .post-edited-by`).html(response.edited_by + edit_message);
								} else {
									$(`#${id} .post-body`).after(`<div class="post-edited-by">${response.edited_by + edit_message}</div>`);
								}
							}

							// Dispay the alert message on the top of the page
							if (response.type !== 'none') {
								ajax_alert(response);
							}

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

						$(this).find('.post-quote').click(function() {
							post_quote($(this));
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
		@endcan
	@endisset
@endauth