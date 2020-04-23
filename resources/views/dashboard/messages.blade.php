@extends('head')

@section('pageTitle')
	{{ __('Messages') }}
@endsection

@php $messages = DB::table('user_messages')->where('recipient_id', $user->id)->paginate(settings_get('posts_per_page')) @endphp

@section('content')
	<div id="messages">
		@foreach ($messages as $message)
			@php $message = App\UserMessage::find($message->id) @endphp
			<div class="message">
				<a class="message-title" href="{{route('dashboard_message', [$message->id])}}">{{ $message->title }}</a>
				<span class="message-from">
					<span>{{ __('From') }}</span>
					<a class="{{role_coloring($message->author->role)}}" href="{{route('user_show', [$message->author->id])}}">
						{{ $message->author->username }}
					</a>
				</span>
			</div>
		@endforeach
	</div>

	{{ $messages->links('layouts.pagination') }}
@endsection

<script>
	$('.nav-link.account').parent().append('<div class="nav-ruler"></div>');
	$('.nav-link.messages').addClass('active');
</script>