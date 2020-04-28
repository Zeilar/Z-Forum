<div class="user-profile">
	<div class="profile-upper">
		<div class="profile-avatar">
			<img class="img-fluid" src="{{$user->avatar}}" alt="{{ __('User profile avatar') }}">
		</div>

		<div class="profile-meta">
			<div class="profile-meta-block profile-name">
				<h3 class="profile-username">
					@isset($user->username)
						{{ $user->username }}
					@else
						<i>{{ __('Deleted') }}</i>
					@endisset
				</h3>
				<h3 class="profile-role {{role_coloring($user->role)}}">{{ ucfirst($user->role) }}</h3>
				<h3 class="profile-rank">{{ ucwords($user->rank) }}</h3>
			</div>

			<div class="profile-meta-stats">
				<div class="profile-registered profile-meta-block">
					<h5 class="profile-meta-upper">{{ __('Joined ') }}</h4>
					<h4 class="profile-meta-lower">{{ pretty_date($user->created_at, ['format' => 'F NS Y']) }}</h3>
				</div>
				<div class="profile-likes profile-meta-block">
					<h5 class="profile-meta-upper">{{ __('Post likes') }}</h5>
					<h4 class="profile-meta-lower">{{ $posts_with_likes->count() }}</h4>
				</div>
				<div class="profile-posts profile-meta-block">
					<h5 class="profile-meta-upper">{{ __('Posts') }}</h4>
					<h4 class="profile-meta-lower">{{ $user->posts->count() }}</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="profile-middle">
		<div class="profile-signature">
			@isset($user->signature)
				<p class="signature">{{ $user->signature }}</p>
			@else
				<p class="no-signature">{{ __('User has no signature') }}</p>
			@endisset
		</div>
	</div>

	<div class="profile-nav">
		<a class="profile-nav-item @if($active === 'activity') active @endif" href="{{route('user_activity', [$user->id])}}">
			{{ __('Activity') }}
		</a>
		<a class="profile-nav-item @if($active === 'threads') active @endif" href="{{route('user_threads', [$user->id])}}">
			{{ __('Threads') }}
		</a>
		<a class="profile-nav-item @if($active === 'posts') active @endif" href="{{route('user_posts', [$user->id])}}">
			{{ __('Posts') }}
		</a>
		<a class="profile-nav-item @if($active === 'likes') active @endif" href="{{route('user_likes', [$user->id])}}">
			{{ __('Likes') }}
		</a>
	</div>
	
	@isset($activities)
		{{ $activities }}
	@endisset

	@isset($threads)
		{{ $threads }}
	@endisset

	@isset($posts)
		{{ $posts }}
	@endisset

	@isset($likes)
		{{ $likes }}
	@endisset
		
	@isset($pagination)
		{{ $pagination }}
	@endisset
</div>