<div class="message">
    <div class="message-title">
        @isset($titleLink)
            <h3>
                <a href="{{ route('dashboard_message', [$message->id]) }}">{{ $message->title }}</a>
            </h3>
        @else
            <h3>{{ $message->title }}</h3>
        @endisset
    </div>

    <div class="message-users">
        <span class="message-from">
            @if ($message->author->id !== auth()->user()->id)
                {{ __('From') }}
                <a class="message-from-user {{role_coloring($message->author->role)}}" href="{{route('user_show', [$message->author->id])}}">
                    {{ $message->author->username }}
                </a>
            @endif
        </span>

        <span class="message-to">
            @if ($message->recipient->id !== auth()->user()->id)
                {{ __('To') }}
                <a class="{{role_coloring($message->recipient->role)}}" href="{{route('user_show', [$message->recipient->id])}}">
                    {{ $message->recipient->username }}
                </a>
            @endif
        </span>

        <span class="message-from-date">{{ pretty_date($message->created_at) }}</span>
    </div>

    <div class="message-content">
        {{ $message->content }}
    </div>
</div>

@isset($replyButton)
    @can('create', App\UserMessage::class)
        @if ($message->author->id !== auth()->user()->id)
            <a class="btn message-reply-button mt-2 mb-4 btn-success-full" href="{{
                route('message_new') . '?replyTo=' . $message->author->username . '&replySubject=' . urlencode($message->title)
            }}">
                <span>{{ __('Reply') }}</span>
                <i class="fas ml-2 color-white fa-reply"></i>
            </a>
        @endif
    @endcan
@endisset

@isset($deleteButton)
    {{ $deleteButton }}
@endisset