@empty($disableSidebar)
	<div id="sidebar">
		@auth
			<div class="sidebar-item welcome">
				<div class="welcome-text">
					<h5 class="sidebar-header">
						{{ __('Welcome ') }} 
						<a class="{{role_coloring(auth()->user()->role)}}" href="{{route('user_show', [auth()->user()->id])}}">
							{{ auth()->user()->username }}
						</a>
					</h5>
					<a class="logout" href="{{route('logout')}}">
						<span>{{ __('Logout') }}</span>
						<i class="fas fa-sign-out-alt"></i>
					</a>
				</div>
				<div class="welcome-avatar">
					<img class="img-fluid" src="/storage/user-avatars/{{auth()->user()->avatar}}" alt="{{ __('User avatar') }}" />
				</div>
			</div>
		@endauth

		<div class="sidebar-item online-users">
			<h5 class="sidebar-header">{{ __('Online moderators') }}</h5>

			@php $users = get_online_users(); @endphp
			@if ($users)
				{{-- Get online superadmins --}}
				@php $superadmins = []; @endphp
				@foreach ($users as $user)
					@if ($user->role === 'superadmin')
						@php array_push($superadmins, $user); @endphp
					@endif
				@endforeach

				{{-- Get online moderators --}}
				@php $moderators = []; @endphp
				@foreach ($users as $user)
					@if ($user->role === 'moderator')
						@php array_push($moderators, $user); @endphp
					@endif
				@endforeach

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
								<span>{{ $comma ?? '' }}</span>
							@endisset
						@endfor
					</div>
				@endif
			@else
				{{ __('No moderator is online') }}
			@endif
		</div>
	</div>
@endempty