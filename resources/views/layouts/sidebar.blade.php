<div id="sidebar">
	@auth
		<div class="sidebar-item welcome">
			<h5 class="sidebar-header">{{ __('Welcome ') . auth()->user()->username }}</h5>
			<a class="logout" href="{{route('logout')}}">
				<span>{{ __('Logout') }}</span>
				<i class="fas fa-sign-out-alt"></i>
			</a>
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

			@for ($i = 0; $i < 5; $i++)
				@isset ($superadmins[$i])
					<a class="is_superadmin" href="{{route('user_show', [$superadmins[$i]->id])}}">{{ $superadmins[$i]->username }}</a>
				@endisset
			@endfor

			@for ($i = 0; $i < 5; $i++)
				@isset ($moderators[$i])
					<a class="is_moderator" href="{{route('user_show', [$moderators[$i]->id])}}">{{ $moderators[$i]->username }}</a>
				@endisset
			@endfor
		@else
			{{ __('No moderator is online') }}
		@endif
	</div>
</div>