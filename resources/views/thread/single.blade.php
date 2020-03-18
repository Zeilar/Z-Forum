{{-- Passed variables: $thread --}}
@extends('layouts.head')

@section('content')
	{{ Breadcrumbs::render('thread', $thread) }}

	<div class="thread-toolbar d-flex flex-row">
		@if (is_role('superadmin', 'moderator'))
			<a class="btn mr-2 thread-edit btn-warning" data-toggle="modal" href="#crudModal">
				<i class="fas color-black fa-pen"></i>
			</a>
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
					<button class="btn btn-success my-2 preview-button" type="button" disabled>
						<span>{{ __('Preview') }}</span>
					</button>
				</form>
			</div>

			<script>
				let interval = setInterval(() => {
					let iframe = $('#quick-reply').find('iframe')[0];
					let iframeWindow = iframe.contentWindow.document;
					let input = $(iframeWindow).find('body');

					if (input.length) clearInterval(interval);

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
					})
				}, 50);
			</script>
		@endif

		@include('js.post.controls')

		@if (is_role('superadmin', 'moderator') || $post->user->id === auth()->user()->id)
			<script>
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
			</script>

			@component('modals.crud', ['route_name' => 'thread_update', 'route_values' => [$thread->id, $thread->slug]])
				@slot('method')
					PUT
				@endslot
				@slot('title')
					{{ __('Edit thread title') }}
				@endslot
				@slot('submit')
					{{ __('Save') }}
				@endslot
			@endcomponent

		@endif
	@endauth

	{{ $posts->links('layouts.pagination') }}

@endsection