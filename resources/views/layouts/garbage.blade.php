@extends('head')

@section('pageTitle')
    {{ __('Garbage') }}
@endsection

@section('content')
    <div id="garbage">
        @if (!count($subcategories) && !count($chat_messages) && !count($user_messages) && !count($categories) && !count($threads) && !count($posts))
            <h2 class="garbage-empty">{{ __('The garbage can is empty') }}</h2>
        @endif

        <div class="categories garbage-wrapper">
            @if (count($categories))
                <h2 class="garbage-title">{{ __('Categories') }}</h2>
            @endif

            @foreach ($categories as $category)
                <div class="item">
                    <span class="title">{{ $category->title }}</span>
                </div>
                <form action="{{route('category_restore', [$category->id])}}" method="post">
                    @csrf
                    <button class="btn btn-hazard restore-button" type="submit">
                        <i class="fas mr-2 fa-undo"></i>
                        <span>{{ __('Restore') }}</span>
                    </button>
                </form>
            @endforeach
        </div>

        <div class="subcategories garbage-wrapper">
            @if (count($subcategories))
                <h2 class="garbage-title">{{ __('Subcategories') }}</h2>
            @endif

            @foreach ($subcategories as $subcategory)
                <div class="item">
                    <span class="title">{{ $subcategory->title }}</span>
                </div>
                <form action="{{route('subcategory_restore', [$subcategory->id])}}" method="post">
                    @csrf
                    <button class="btn btn-hazard restore-button" type="submit">
                        <i class="fas mr-2 fa-undo"></i>
                        <span>{{ __('Restore') }}</span>
                    </button>
                </form>
            @endforeach
        </div>
        
        <div class="threads garbage-wrapper">
            @if (count($threads))
                <h2 class="garbage-title">{{ __('Threads') }}</h2>
            @endif

            @foreach ($threads as $thread)
                <div class="item">
                    <span class="title">{{ $thread->title }}</span>
                </div>
                <form action="{{route('thread_restore', [$thread->id])}}" method="post">
                    @csrf
                    <button class="btn btn-hazard restore-button" type="submit">
                        <i class="fas mr-2 fa-undo"></i>
                        <span>{{ __('Restore') }}</span>
                    </button>
                </form>
            @endforeach
        </div>

        <div class="chat-messages garbage-wrapper">
            @if (count($chat_messages))
                <h2 class="garbage-title">{{ __('Chat messages') }}</h2>

                @foreach ($chat_messages as $message)
                    @include('components.chat-message', ['message' => $message])
                    <form action="{{route('chat_restore', [$message->id])}}" method="post">
                        @csrf
                        <button class="btn btn-hazard restore-button" type="submit">
                            <i class="fas mr-2 fa-undo"></i>
                            <span>{{ __('Restore') }}</span>
                        </button>
                    </form>
                @endforeach

                @include('js.parse-emotes')
                <script>
                    $('#garbage .chat-message .message-content').each(function() {
                        parseEmotes($(this));
                    });
                </script>
            @endif
        </div>

        <div class="user-messages garbage-wrapper">
            @if (count($user_messages))
                <h2 class="garbage-title">{{ __('User messages') }}</h2>
            @endif

            @foreach ($user_messages as $message)
                @component('components.message', ['message' => $message])
                    @slot('deleteButton')
                        @can('delete', $message)
                            @if ($message->is_deleted())
                                <form action="{{route('message_restore', [$message->id])}}" method="post">
                                    @csrf
                                    <button class="btn btn-hazard mt-2 restore-button" type="submit">
                                        <i class="fas mr-2 fa-undo"></i>
                                        <span>{{ __('Restore') }}</span>
                                    </button>
                                </form>
                            @else
                                <form action="{{route('message_delete', [$message->id])}}" method="post">
                                    @csrf
                                    <button class="btn btn-hazard mt-2" type="submit">
                                        <i class="fas mr-2 fa-exclamation-triangle"></i>
                                        <span>{{ __('Delete') }}</span>
                                    </button>
                                </form>
                            @endif
                        @endcan
                    @endslot
                @endcomponent
            @endforeach
        </div>

        <div class="posts garbage-wrapper">
            @if (count($posts))
                <h2 class="garbage-title">{{ __('Posts') }}</h2>
            @endif

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