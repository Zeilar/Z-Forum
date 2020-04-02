{{-- Passed variables: $thread --}}
@extends('head')

@section('pageTitle')
	{{ $thread->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('thread', $thread) }}
@endsection

@can('update', $thread)
	@section('crudToolbar')
		<div class="crud-toolbar">
			<button class="btn btn-default thread-edit">
				<i class="fas fa-pen"></i>
			</button>
			@if ($thread->locked)
				<button class="btn btn-default spin thread-toggle" type="button">
					<i class="fas fa-unlock"></i>
				</button>
			@else
				<button class="btn btn-default spin thread-toggle" type="button">
					<i class="fas fa-lock"></i>
				</button>
			@endif
			@can('delete', $thread)
				<button class="btn btn-hazard spin thread-delete" type="submit">
					<i class="fas fa-trash-alt"></i>
				</button>
			@endcan
		</div>
	@endsection
@endcan

@section('threadTitle')
	<div class="thread-header">
		<h4 class="thread-title">{{ $thread->title }}</h4>
	</div>
@endsection

@section('content')
	<div class="thread @if ($thread->locked) locked @endif">
		{{-- Don't even ask, it just works --}}
		@php $i = ($posts->currentPage() - 1) * $posts->perPage() + 1; @endphp

		@foreach ($posts as $post)
			@component('components.post', ['post' => $post, 'i' => $i])
				
			@endcomponent
			@php $i++; @endphp
		@endforeach
	</div>

	@auth
		@can('create', [App\Post::class, $thread])
			<div id="quick-reply">
				<form action="{{route('post_store', [$thread->id, $thread->slug])}}" method="POST">
					@csrf
					<textarea type="text" name="content" id="form-content"></textarea>
					@error('content') <p class="color-red">{{ $message }}</p> @enderror
					<button class="btn post-send spin btn-success" type="submit" disabled>
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
		@endcan

		@include('js.post.controls')

		@can('update', $thread)
			<script>
				// Init the handlers
				thread_handlers();

				// Toggle thread lock/unlock state
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
							$('.thread-toggle').removeClass('loading');
							ajax_alert(response);

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

				// Edit thread title
				function thread_edit() {
					if (!$('.thread-save-toolbar').length) {
						let title = $('.thread-title').html();

						$('.thread-title').replaceWith(`
							<fieldset style="width: ${$('#main').width()}px;">
								<legend>
									Title
								</legend>
								<input type="text" value="${title}" />
							</fieldset>
						`);
						$('.thread-header').append(`
							<div class="thread-save-toolbar">
								<button class="btn btn-success-full spin thread-save">
									<span>Save</span>
								</button>
								<button class="btn btn-default spin thread-cancel">
									<span>Cancel</span>
								</button>
							</div>
						`);
					}
				}

				// Cancel the edited thread and reset elements to how they were before
				function thread_cancel(original) {					
					// Reset thread header and edit button
					$('.thread-header').html(original);
					$('.thread-edit').removeAttr('disabled');

					// The event handler needs to be re-initalized since the element was destroyed
					thread_handlers();
				}

				// Save the edited post and reset elements to how they were before, but with the updated post content
				function thread_save(original, e) {
					e.preventDefault();
					$.ajax({
						url: '{{ route("thread_update_ajax") }}',
						method: 'POST',
						data: {
							_token: '{{ Session::token() }}',
							id: '{{ $thread->id }}',
							title: $('.thread-header input').val()
						},
						success: function(response) {
							// Reset post element and remove TinyMCE editor first
							$('.thread-header').html(original);

							// Insert the newly edited content into the post
							$('.thread-title').html(response.title);

							$('.thread-edit').removeAttr('disabled');

							// Edit the active breadcrumb content
							$('.breadcrumb-item.active').html(response.title);

							// Edit the current URL state for better UX in case user reloads, otherwise it will go to the old item URL
							window.history.pushState("", "", response.url);

							// Dispay the alert message on the top of the page
							if (response.type !== 'none') {
								ajax_alert(response);
							}

							// The event handlers need to be reinitalized since the element was destroyed
							thread_handlers();
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
		@elsecan ('delete', $thread)
			<script>
				// Delete thread
				function thread_delete(e) {
					e.preventDefault();
					$.ajax({
						url: '{{ route("thread_delete_ajax") }}',
						method: 'POST',
						data: {
							_token: '{{ Session::token() }}',
							id: '{{ $thread->id }}',
						},
						success: function(response) {
							window.location.href = response.redirect;
						},
						error: function(error) {
							console.log(error);
						}
					});
				}
			</script>
		@endcan
	@endauth

	{{ $posts->links('layouts.pagination') }}
@endsection