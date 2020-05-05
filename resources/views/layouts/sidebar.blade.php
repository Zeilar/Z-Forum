@empty($disableSidebar)
	@isset ($_COOKIE['sidebarOpen'])
		@php $class = 'open' @endphp
	@else
		@php $class = 'hide' @endphp
	@endisset	
	<div class="{{$class}}" id="sidebar">
		@auth
			@component('components.sidebar-item', ['class' => 'welcome'])
				@slot('title')
					<i class="fas fa-home"></i>
					{{ __('Welcome ') . auth()->user()->username }}
				@endslot

				@slot('content')
					<div class="wrapper">
						<div class="welcome-text">
							<p class="user-role {{role_coloring(auth()->user()->role)}}">{{ ucfirst(auth()->user()->role) }}</p>
                            <p>{{ ucfirst(auth()->user()->rank) }}</p>
							<a href="{{route('user_show', [auth()->user()->id])}}">
								{{ __('Profile') }}
							</a>
						</div>
						<div class="welcome-avatar">
							<img class="img-fluid" src="{{auth()->user()->avatar}}" alt="{{ __('User avatar') }}" />
						</div>
					</div>
				@endslot
			@endcomponent

            @component('components.sidebar-item', ['class' => 'whats-new'])
				@slot('title')
					<i class="fas fa-rss"></i>
					{{ __('What\'s new') }}
				@endslot

				@slot('content')                    
                    @if (count($whats_new))
                        @foreach ($whats_new as $post)
                            @php $thread = $post->thread @endphp
                            <div class="whats-new-thread">
                                <i class="fas fa-chevron-right"></i>
                                <a class="whats-new-link @if($post->user->role === 'superadmin') is_superadmin @endif" href="{{
                                    route('post_show', [
                                        $thread->id,
                                        $thread->slug,
                                        get_item_page_number(
                                            $thread->posts,
                                            $post->id,
                                            settings_get('posts_per_page')
                                        ),
                                        $post->id,
                                    ])
                                }}">
                                    {{ $thread->title }}
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p>{{ __('You are all up to date!') }}</p>
                    @endif
				@endslot
			@endcomponent
		@endauth
        
        @component('components.sidebar-item', ['class' => 'chat'])
            @php $messages = App\ChatMessage::orderByDesc('created_at')->limit(30)->get()->reverse() @endphp

            @slot('title')
                {{ __('Chat') }}
            @endslot

            @slot('content')
                <div id="chat">
                    <div class="chat-box">
                        @forelse ($messages as $message)
                            <div class="chat-message">
                                <p class="message-content">
                                    <a class="{{role_coloring($message->user->role)}}" href="{{route('user_show', [$message->user->id])}}">
                                        {{ $message->user->username }}
                                    </a>
                                    <span>{{ $message->content }}</span>
                                </p>
                            </div>
                        @empty
                            <p class="no-messages">{{ __('No messages were found.') }}</p>
                        @endforelse
                    </div>

                    @auth  
                        <div class="chat-input">
                            <form>
                                <input type="text" id="chat-content" autocomplete="off">
                                <button type="submit">{{ __('Send') }}</button>
                            </form>
                        </div>
                    @endauth
                </div>

                @auth
                    <script>
                        $('#chat form').submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: '{{ route("chat_send") }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ Session::token() }}',
                                    author_id: '{{ auth()->user()->id }}',
                                    content: $('#chat-content').val(),
                                },
                                success: function(response) {
                                    if (response.error) {
                                        if (!$('.chat-error').length && response.message != null) {
                                            $('.chat-input').prepend(`<p class="chat-error" style="color: red;">${response.message}</p>`);
                                            setTimeout(() => {
                                                $('#chat-content').removeClass('error');
                                                $('.chat-error').remove();
                                            }, 30000);
                                            $('#chat-content').addClass('error');
                                        }
                                    } else {
                                        if ($('.no-messages').length) $('.no-messages').remove();
                                        if ($('.chat-error').length) $('.chat-error').remove();

                                        let message = $(`
                                            <div class="chat-message">
                                                <p class="message-content">
                                                    ${response.author}:
                                                    <span></span>
                                                </p>
                                            </div>
                                        `);

                                        $('.chat-box').append(message);
                                        message.find('span').text(`${response.content}`);
                                        $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
                                        $('#chat-content').removeClass('error');
                                        $('#chat-content').val('').focus();
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });
                        });
                    </script>
                @endauth
            @endslot
        @endcomponent

		@component('components.sidebar-item', ['class' => 'latest-posts'])
			@slot('title')
				<i class="far fa-comments"></i>
				{{ __('Recent activity') }}
			@endslot

			@slot('content')
				@php $latest_posts = App\Post::all()->sortByDesc('created_at') @endphp

				{{-- Filter out duplicate threads --}}
				@php $threads = [] @endphp
				@foreach ($latest_posts as $post)
					@if (count($threads) >= 5)
						@break
					@endif
					@if (!in_array($post->thread, $threads))
						@php array_push($threads, $post->thread) @endphp
					@endif
				@endforeach

                @if (count($threads))   
                    @foreach ($threads as $thread)
                        <div class="latest-posts-item">
                            <i class="fas fa-chevron-right"></i>
                            <a class="thread @if($thread->posts()->latest()->first()->user->role === 'superadmin') is_superadmin @endif"
                                href="{{route('thread_show', [$thread->id, $thread->slug])}}
                            ">
                                {{ $thread->title }}
                            </a>
                        </div>
                    @endforeach
                @endif
			@endslot
		@endcomponent

		@component('components.sidebar-item', ['class' => 'online-moderators'])
			@slot('content')
				@php $online_users = get_online_users() @endphp
				@php $superadmins = [] @endphp
				@php $moderators = [] @endphp

				@if ($online_users)
					{{-- Get online superadmins --}}
					@foreach ($online_users as $user)
						@if ($user->role === 'superadmin')
							@php $superadmins[] = $user @endphp
						@endif
					@endforeach

					{{-- Get online moderators --}}
					@foreach ($online_users as $user)
						@if ($user->role === 'moderator')
							@php $moderators[] = $user @endphp
						@endif
					@endforeach
				@endif

				@php $amount = count($superadmins) + count($moderators) ?? 0 @endphp

				@slot('title')
					<i class="fas fa-users-cog"></i>
					{{ __("Online moderators: $amount") }}
				@endslot

				@if ($amount)
					@if (count($superadmins))
						<div class="sidebar-superadmins">
							<h5 class="is_superadmin">{{ __('Superadmins') }}</h5>

							@for ($i = 0; $i < count($superadmins); $i++)
								@isset ($superadmins[$i])
									<a href="{{route('user_show', [$superadmins[$i]->id])}}">{{ $superadmins[$i]->username }}</a>
								@endisset
							@endfor
						</div>
					@endif

					@if (count($moderators))
						<div class="sidebar-moderators">
							<h5 class="is_moderator">{{ __('Moderators') }}</h5>

							@for ($i = 0; $i < count($moderators); $i++)
								@isset ($moderators[$i])
									<a href="{{route('user_show', [$moderators[$i]->id])}}">{{ $moderators[$i]->username }}</a>
								@endisset
							@endfor
						</div>
					@endif
				@else
					<div class="sidebar-offline">
						<p>{{ __('No moderator is online 👻') }}</p>
						<span><i class="far fa-envelope"></i></span>
						<a class="contact-admin" href="mailto:admin@zforum.nu" target="_blank">admin@zforum.nu</a>
					</div>
				@endif
			@endslot
		@endcomponent

		@component('components.sidebar-item', ['class' => 'statistics'])
			@slot('title')
				<i class="fas fa-chart-line"></i>
				{{ __('Statistics') }}
			@endslot

			@slot('content')
				<div class="statistics-item">
					<span class="statistics-item-title">{{ __('Users online') }}</span>
					<span class="statistics-item-content">{{ count(get_online_users()) }}</span>
				</div>

				<div class="statistics-item">
					<span class="statistics-item-title">{{ __('Posts') }}</span>
					<span class="statistics-item-content">{{ App\Post::all()->count() }}</span>
				</div>

				<div class="statistics-item">
					<span class="statistics-item-title">{{ __('Threads') }}</span>
					<span class="statistics-item-content">{{ App\Thread::all()->count() }}</span>
				</div>

				<div class="statistics-item">
					<span class="statistics-item-title">{{ __('Members') }}</span>
					<span class="statistics-item-content">{{ App\User::all()->count() }}</span>
				</div>
			@endslot
		@endcomponent
	</div>
@endempty