@extends('head')

@section('pageTitle')
	{{ $message->title }}
@endsection

@section('content')
	<div id="message">
		<div class="message-title">
			<h3>{{ $message->title }}</h3>
		</div>

		<div class="message-users">
			<span class="message-from">
				{{ __('From') }}
				@if ($message->author->id === auth()->user()->id)
					<span>{{ __('You') }}</span>
				@else
					<a href="{{route('user_show', [$message->author->id])}}">{{ $message->author->username }}</a>
				@endif
			</span>

			<span class="message-to">
				{{ __('To') }}
				@if ($message->recipient->id === auth()->user()->id)
					<span>{{ __('You') }}</span>
				@else
					<a href="{{route('user_show', [$message->recipient->id])}}">{{ $message->recipient->username }}</a>
				@endif
			</span>
		</div>

		<div class="message-content">
			{{ $message->content }}
		</div>
	</div>
@endsection