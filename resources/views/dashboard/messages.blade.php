@extends('head')

@section('pageTitle')
	{{ __('Messages') }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('messages') }}
@endsection

@section('content')
	{{ $messages->links('layouts.pagination') }}
	
    @if (logged_in() && !auth()->user()->is_suspended())
        <a class="btn new-message btn-success-full" href="{{route('message_new')}}">
            {{ __('Send a message') }}
        </a>
    @endif

	@if (session('success'))
		<p class="flash-success messages">{{ session('success') }}</p>
	@endif

	<div id="messages">
		@foreach ($messages as $message)
			@php $message = App\UserMessage::find($message->id) @endphp
			@if ($user->visited_messages->where('user_message_id', $message->id)->count())
				@php $read = 'read' @endphp
			@else
				@php $read = '' @endphp
			@endif
			<div class="profile-message {{$read}}">
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
					<span class="message-date">{{ pretty_date($message->created_at) }}</span>
				</span>
			</div>
		@endforeach
	</div>

	@if (settings_get('posts_per_page') >= 5)
		{{ $messages->links('layouts.pagination') }}
	@endif

	<script>
		$('.nav-link.messages').parent().append('<div class="nav-ruler"></div>');
		$('.nav-link.messages').addClass('active');
	</script>
@endsection