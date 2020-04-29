@empty($disableSidebar)
	@isset ($_COOKIE['sidebarOpen'])
		@php $class = 'open' @endphp
	@else
		@php $class = 'hide' @endphp
	@endisset	
	<div class="no-transition {{$class}}" id="sidebar">
		@auth
			@component('components.sidebar-item', ['class' => 'welcome'])
				@slot('title')
					<i class="fas fa-home"></i>
					{{ __('Welcome ') . $user->username }}
				@endslot

				@slot('content')
					<div class="wrapper">
						<div class="welcome-text">
							<p class="user-role {{role_coloring($user->role)}}">{{ ucfirst($user->role) }}</p>
							<a href="{{route('user_show', [$user->id])}}">
								{{ __('Profile') }}
							</a>
						</div>
						<div class="welcome-avatar">
							<img class="img-fluid" src="{{$user->avatar}}" alt="{{ __('User avatar') }}" />
						</div>
					</div>
				@endslot
			@endcomponent
		@endauth

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
									<a href="{{route('user_show', [$superadmins[$i]->id])}}">
										@if (count($superadmins) > 1 && $i !== count($superadmins) - 1)
											@php $comma = ','; @endphp
										@else
											@php $comma = ''; @endphp
										@endif
										{{ $superadmins[$i]->username }}
									</a>
									<span class="separator">{{ $comma }}</span>
								@endisset
							@endfor
						</div>
					@endif

					@if (count($moderators))
						<div class="sidebar-moderators">
							<h5 class="is_moderator">{{ __('Moderators') }}</h5>

							@for ($i = 0; $i < count($moderators); $i++)
								@isset ($moderators[$i])
									<a href="{{route('user_show', [$moderators[$i]->id])}}">
										@if (count($moderators) > 1 && $i !== count($moderators) - 1)
											@php $comma = ', '; @endphp
										@else
											@php $comma = ''; @endphp
										@endif
										{{ $moderators[$i]->username }}
									</a>
									<span class="separator">{{ $comma }}</span>
								@endisset
							@endfor
						</div>
					@endif
				@else
					<div class="sidebar-offline">
						<p>{{ __('No moderator is online 👻') }}</p>
						<span><i class="far fa-envelope"></i></span>
						<a href="mailto:admin@zforum.nu" target="_blank">admin@zforum.nu</a>
					</div>
				@endif
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
					@if (count($threads) >= 10)
						@break
					@endif
					@if (!in_array($post->thread, $threads))
						@php array_push($threads, $post->thread) @endphp
					@endif
				@endforeach

				@foreach ($threads as $thread)
					<div class="latest-posts-item">
						<i class="fas fa-chevron-right"></i>
						<a class="thread" href="{{route('thread_show', [$thread->id, $thread->slug])}}">
							{{ $thread->title }}
						</a>
					</div>
				@endforeach
			@endslot
		@endcomponent

		@component('components.sidebar-item', ['class' => 'statistics'])
			@slot('title')
				<i class="fas fa-chart-line"></i>
				{{ __('Statistics') }}
			@endslot

			@slot('content')
				<div class="statistics-item">
					<span class="statistics-item-title">{{ __('Users online:') }}</span>
					<span class="statistics-item-content">{{ count(get_online_users()) }}</span>
				</div>

				<div class="statistics-item">
					<span class="statistics-item-title">{{ __('Posts:') }}</span>
					<span class="statistics-item-content">{{ App\Post::all()->count() }}</span>
				</div>

				<div class="statistics-item">
					<span class="statistics-item-title">{{ __('Threads:') }}</span>
					<span class="statistics-item-content">{{ App\Thread::all()->count() }}</span>
				</div>

				<div class="statistics-item">
					<span class="statistics-item-title">{{ __('Members:') }}</span>
					<span class="statistics-item-content">{{ App\User::all()->count() }}</span>
				</div>
			@endslot
		@endcomponent
	</div>
@endempty