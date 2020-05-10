@extends('head')

@section('pageTitle')
    {{ __('Garbage') }}
@endsection

@section('content')
    <div id="garbage">
        @if (!count($subcategories) && !count($chat_messages) && !count($user_messages) && !count($categories) && !count($threads) && !count($posts))
            <h2 class="garbage-empty">{{ __('The garbage can is empty') }}</h2>
        @endif

        <div class="threads garbage-wrapper">
            @foreach ($threads as $thread)
                <div class="thread">
                    <span class="thread-title">{{ $thread->title }}</span>
                    <form action="{{route('thread_restore', [$thread->id])}}" method="post">
                        @csrf
                        <button class="restore-button" type="submit">
                            <i class="fas fa-undo"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="chat-messages garbage-wrapper">
            @if (count($chat_messages))
                @foreach ($chat_messages as $message)
                    <div class="chat-message">
                        <div class="message-meta">
                            <a class="{{role_coloring($message->user->role)}}" href="{{route('user_show', [$message->user->role])}}">
                                {{ $message->user->username }}
                            </a>
                            <span class="message-date">{{ pretty_date($message->created_at) }}</span>
                            <form action="{{route('chat_restore', [$message->id])}}" method="post">
                                @csrf
                                <button class="restore-button" type="submit">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </form>
                        </div>
                        <div class="message-content">
                            {{ $message->content }}
                        </div>
                    </div>
                @endforeach

                @include('js.parse-emotes')
                <script>
                    $('#garbage .chat-message .message-content').each(function() {
                        parseEmotes($(this));
                    });
                </script>
            @endif
        </div>

        <div class="posts garbage-wrapper">
            @foreach($posts as $post)
                @component('components.post', [
                    'post'				   => $post,
                    'disablePostToolbar'   => true,
                    'disablePostBanner'    => true,
                    'disablePostSignature' => true,
                    'deleted'              => true,
                ])  
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection