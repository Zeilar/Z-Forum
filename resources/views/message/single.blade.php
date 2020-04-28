@extends('head')

@section('pageTitle')
	{{ $message->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('message', $message) }}
@endsection

@section('content')
	<div id="message">
		<div class="message-title">
			<h3>{{ $message->title }}</h3>
		</div>

		<div class="message-users">
			<span class="message-from">
				@if ($message->author->id !== auth()->user()->id)
					{{ __('From') }}
					<a class="message-from-user {{role_coloring($message->author->role)}}" href="{{route('user_show', [$message->author->id])}}">
						{{ $message->author->username }}
					</a>
				@endif

				<span class="message-from-date">{{ pretty_date($message->created_at) }}</span>
			</span>

			<span class="message-to">
				@if ($message->recipient->id !== auth()->user()->id)
					{{ __('To') }}
					<a href="{{route('user_show', [$message->recipient->id])}}">{{ $message->recipient->username }}</a>
				@endif
			</span>
		</div>

		<div class="message-content">
			{{ $message->content }}
		</div>
	</div>

	@if ($message->author->id !== auth()->user()->id)
		<a class="btn mt-2 btn-success-full" href="{{
			route('message_new') . '?replyTo=' . $message->author->username . '&replySubject=' . urlencode($message->title)
		}}">
			<span>{{ __('Reply') }}</span>
			<i class="fas ml-2 color-white fa-reply"></i>
		</a>
	@endif
@endsection