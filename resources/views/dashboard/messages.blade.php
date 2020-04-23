@extends('head')

@section('pageTitle')
	{{ __('Messages') }}
@endsection

@php
	$messages = DB::table('user_messages')
		->where('author_id', $user->id)
		->orWhere('recipient_id', $user->id)
		->orderByDesc('id')
		->paginate(settings_get('posts_per_page'))
@endphp

@section('content')
	<a class="btn new-message btn-success-full" href="{{route('message_new')}}">
		{{ __('Send a message') }}
	</a>

	{{ $messages->links('layouts.pagination') }}

	@if (session('success'))
		<p class="flash-success messages">{{ session('success') }}</p>
	@endif

	<div id="messages">
		@foreach ($messages as $message)
			@php $message = App\UserMessage::find($message->id) @endphp
			<div class="message">
				<a class="message-title" href="{{route('dashboard_message', [$message->id])}}">{{ $message->title }}</a>
				<span class="message-from-to">
					@if ($message->author->id === auth()->user()->id)
						<span>{{ __('Sent to') }}</span>
						<a class="{{role_coloring($message->recipient->role)}}" href="{{route('user_show', [$message->recipient->id])}}">
							{{ $message->recipient->username }}
						</a>
					@else
						<span>{{ __('From') }}</span>
						<a class="{{role_coloring($message->author->role)}}" href="{{route('user_show', [$message->author->id])}}">
							{{ $message->author->username }}
						</a>
					@endif
				</span>
			</div>
		@endforeach
	</div>

	{{ $messages->links('layouts.pagination') }}

	<script>
		$('.nav-link.messages').parent().append('<div class="nav-ruler"></div>');
		$('.nav-link.messages').addClass('active');
	</script>
@endsection