@extends('head')

@section('pageTitle')
	{{ $user->username . ' | ' . __('Threads') }}
@endsection

@section('content')
	@component('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => 'threads'])
		@slot('threads')
			<div class="profile-threads">
				@if (count($threads))
					@foreach ($threads as $thread)
						<div class="profile-thread">
							<a href="{{route('thread_show', [$thread->id, $thread->slug])}}">
								{{ $thread->title }}
							</a>
						</div>
					@endforeach
				@else
					<div class="profile-thread">
						{{ __('No threads were found 🤔') }}
					</div>
				@endif
			</div>
		@endslot

		@slot('pagination')
			{{ $threads->links('layouts.pagination') }}
		@endslot
	@endcomponent
@endsection