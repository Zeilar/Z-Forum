@empty($disableSidebar)
	<div id="sidebar">
		@auth
			@component('components.sidebar-item', ['class' => 'welcome'])
				@slot('legend')
					{{ __('Welcome') }}
				@endslot

				@slot('content')
					<div class="wrapper">
						<div class="welcome-text">
							<h5 class="sidebar-header">
								<a class="{{role_coloring(auth()->user()->role)}}" href="{{route('user_show', [auth()->user()->id])}}">
									{{ auth()->user()->username }}
								</a>
							</h5>
							@if (is_role('superadmin', 'moderator'))
								<p class="user-role">{{ ucfirst(auth()->user()->role) }}</p>
							@endif
							<a class="logout" href="{{route('logout')}}">
								<span>{{ __('Logout') }}</span>
								<i class="fas fa-sign-out-alt"></i>
							</a>
						</div>
						<div class="welcome-avatar" data-title="{{ auth()->user()->username }}">
							<img class="img-fluid" src="/storage/user-avatars/{{auth()->user()->avatar}}" alt="{{ __('User avatar') }}" />
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

				@slot('legend')
					{{ __("Online moderators: $amount") }}
				@endslot

				@if ($amount)
					@if (count($superadmins))
						<div class="sidebar-admins">
							@for ($i = 0; $i < count($superadmins); $i++)
								@isset ($superadmins[$i])
									<a class="is_superadmin" href="{{route('user_show', [$superadmins[$i]->id])}}">
										@if (count($superadmins) > 1 && $i !== count($superadmins) - 1)
											@php $comma = ','; @endphp
										@else
											@php $comma = false; @endphp
										@endif
										{{ $superadmins[$i]->username }}
									</a>
									<span>{{ $comma ?? '' }}</span>
								@endisset
							@endfor
						</div>
					@endif

					@if (count($moderators))
						<div class="sidebar-moderators">
							@for ($i = 0; $i < count($moderators); $i++)
								@isset ($moderators[$i])
									<a class="is_moderator" href="{{route('user_show', [$moderators[$i]->id])}}">
										@if (count($moderators) > 1 && $i !== count($moderators) - 1)
											@php $comma = ','; @endphp
										@else
											@php $comma = false; @endphp
										@endif
										{{ $moderators[$i]->username }}
									</a>
									<span class="separator">{{ $comma ?? '' }}</span>
								@endisset
							@endfor
						</div>
					@endif
				@else
					<div class="sidebar-offline">
						<p>{{ __('No moderator is online 👻') }}</p>
						<span>{{ __('Contact:') }}</span>
						<a href="mailto:admin@zforum.nu" target="_blank">admin@zforum.nu</a>
					</div>
				@endif
			@endslot
		@endcomponent
	</div>

	<script>
		// Since double border in fieldset doesn't work, this will have to do
		$('.sidebar-legend-fixer').each(function() {
			let width = $(this).parent().siblings('legend').outerWidth();
			$(this).css('width', `${width}px`);
		});
	</script>
@endempty