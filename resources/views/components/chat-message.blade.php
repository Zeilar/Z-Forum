<div class="chat-message" id="chat-message-{{$message->id}}">
    <div class="message-content">
        <a class="{{role_coloring($message->user->role)}}" href="{{route('user_show', [$message->user->id])}}">
            {{ $message->user->username }}
        </a>
        <span class="message-timestamp">{{ pretty_date($message->created_at) }}</span>
        @can('delete', $message)
            <button class="chat-message-remove" type="button">
                <i class="far fa-trash-alt"></i>
            </button>
        @endcan
    </div>
    <p class="content">{{ $message->content }}</p>
</div>