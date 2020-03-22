{{-- Passed variables: $thread --}}
@extends('layouts.head')

@section('content')
	{{ Breadcrumbs::render('thread', $thread) }}

	<div class="thread-toolbar d-flex flex-row">
		@if (is_role('superadmin', 'moderator'))
			<button class="btn mr-2 thread-edit btn-warning">
				<i class="fas color-black fa-pen"></i>
			</button>
			@if ($thread->locked)
				<button class="btn mr-2 spin thread-toggle btn-secondary" type="button">
					<i class="fas color-white fa-unlock"></i>
				</button>
			@else
				<button class="btn mr-2 spin thread-toggle btn-secondary" type="button">
					<i class="fas color-white fa-lock"></i>
				</button>
			@endif
			<form action="{{route('thread_delete', [$thread->id, $thread->slug])}}" method="post">
				@csrf
				<input type="hidden" name="_method" value="DELETE">
				<button class="btn mr-2 spin btn-danger" type="submit">
					<i class="fas color-white fa-trash-alt"></i>
				</button>
			</form>
		@endif
	</div>

	<div class="thread @if ($thread->locked) locked @endif">
		<div class="thread-header">
			<h5 class="thread-title">{!! $thread->title !!}</h5>
		</div>

		{{-- Don't even ask, it just works --}}
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
					@error('content') <p class="color-red">{{ $message }}</p> @enderror
					<button class="btn spin btn-success my-2 mr-2" type="submit" disabled>
						<span>{{ __('Send') }}</span>
					</button>
				</form>
			</div>

			<script>
				let interval = setInterval(() => {
					if ($('#quick-reply').find('iframe').length) {
						clearInterval(interval);
						let iframe = $('#quick-reply').find('iframe')[0];
						let iframeWindow = iframe.contentWindow.document;
						let input = $(iframeWindow).find('body');
						input.focus();

						input.on('input', function() {
							if ($(this).html() !== '<p><br></p>' && $(this).html() !== '') {
								$('#quick-reply button').each(function() {
									$(this).removeAttr('disabled');
								});
							} else {
								$('#quick-reply button').each(function() {
									$(this).attr('disabled', true);
								});
							}
						});
					}
				}, 50);
			</script>
		@endif

		@include('js.post.controls')

		@if (is_role('superadmin', 'moderator'))
			<script>
				thread_handlers();

				$('.thread-toggle').click(function(e) {
					e.preventDefault();
					$.ajax({
						url: '{{ route("thread_toggle") }}',
						method: 'POST',
						data: {
							_token: '{{ Session::token() }}',
							id: '{{ $thread->id }}',
						},
						success: function(response) {
							ajax_alert(response);
							$('.thread-toggle').removeClass('loading')

							// Need to delay this due to .spin event handler code being fired after this 
							setTimeout(() => {
								$('.thread-toggle').removeAttr('disabled');
							}, 100);

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

				function thread_edit() {
					if (!$('.thread-save-toolbar').length) {
						let title = $('.thread-title').html();

						$('.thread-title').replaceWith(`<input type="text" value="${title}" /> `);
						$('.thread-header').append(`
							<div class="thread-save-toolbar">
								<button class="btn btn-success spin thread-save">
									<span>Save</span>
								</button>
								<button class="btn btn-success spin thread-cancel">
									<span>Cancel</span>
								</button>
							</div>
						`);
					}
				}

				// Cancel the edited thread and reset elements to how they were before
				function thread_cancel(original) {					
					// Reset thread header
					$('.thread-header').html(original);

					$('.thread-edit').removeAttr('disabled');

					// The event handler needs to be re-initalized since the element was destroyed
					thread_handlers();
				}

				// Save the edited post and reset elements to how they were before, but with the updated post content
				function thread_save(original, e) {
					let originalTitle = '{{ $thread->title }}';
					let id = '{{ $thread->id }}';

					e.preventDefault();
					$.ajax({
						url: '{{ route("thread_update_ajax") }}',
						method: 'POST',
						data: {
							_token: '{{ Session::token() }}',
							id: id,
							title: $('.thread-header input').val()
						},
						success: function(response) {
							// Reset post element and remove TinyMCE editor first
							$('.thread-header').html(original);

							// Insert the newly edited content into the post
							$('.thread-title').html(response.title);

							// Edit the active breadcrumb content
							$('.breadcrumb-item.active').html(response.title);

							// Edit the current URL state for better UX in case user reloads, otherwise it will return 404
							window.history.pushState("", "", response.url);

							// Dispay the alert message on the top of the page
							if (response.type !== 'none') {
								ajax_alert(response);
							}

							// The event handler needs to be re-initalized since the element was destroyed
							thread_handlers();
						},
						error: function(error) {
							console.log(error);
						}
					});
				}

				// Delete thread
				function thread_delete(element, e) {
					let id = element.parents('.post').attr('id');

					e.preventDefault();
					$.ajax({
						url: '{{ route("thread_delete_ajax") }}',
						method: 'POST',
						data: {
							_token: '{{ Session::token() }}',
							id: id,
						},
						success: function(response) {
							window.location.href = response.redirect;
						},
						error: function(error) {
							console.log(error);
						}
					});
				}

				// Initialize post handlers in order to let them be "recursive"
				function thread_handlers() {
					let original = $('.thread-header').html();

					$('.thread-edit').click(function() {
						thread_edit();

						$('.thread-save').click(function(e) {
							thread_save(original, e);
						});

						$('.thread-cancel').click(function() {
							thread_cancel(original);
						});

						// Put disabled on edit button
						$(this).attr('disabled', true);
					});

					$('.thread-delete').click(function(e) {
						thread_delete(e);
					});
				}
			</script>
		@endif
	@endauth

	{{ $posts->links('layouts.pagination') }}

@endsection