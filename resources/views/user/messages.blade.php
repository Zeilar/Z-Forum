@extends('head')

@section('pageTitle')
	{{ ($user->username ?? __('Deleted')) . ' | ' . __('Messages') }}
@endsection

@section('content')
	@component('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => 'messages'])
		@slot('messages')
			<div class="profile-messages">
                @if (count($messages))
                    @foreach ($messages as $message)
                        @component('components.message', ['message' => $message, 'replyButton' => true])
                            
                        @endcomponent
                    @endforeach
                @else
                    <p>{{ __('No messages were found 👻') }}</p>

                    @if ($message->author->id !== auth()->user()->id)
                        <a class="btn mt-2 btn-success-full" href="{{
                            route('message_new') . '?replyTo=' . $user->username
                        }}">
                            <span>{{ __('Send a message') }}</span>
                            <i class="fas ml-2 color-white fa-reply"></i>
                        </a>
                    @endif
                @endif
            </div>
		@endslot

		@if ($messages)
			@slot('pagination')
				{{ $messages->links('layouts.pagination') }}
			@endslot
		@endif
	@endcomponent
@endsection