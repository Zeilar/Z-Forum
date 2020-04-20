@extends('head')

@section('pageTitle')
	{{ __('User | ') . $user->username }}
@endsection

@section('content')
	<div class="user-profile">
		<div class="profile-upper">
			<div class="profile-avatar">
				<img class="img-fluid" src="{{$user->avatar}}" alt="{{ __('User profile avatar') }}">
			</div>

			<div class="profile-meta">
				<div class="profile-meta-block profile-name">
					<h3 class="profile-username">{{ $user->username }}</h3>
					<h3 class="profile-role {{role_coloring($user->role)}}">{{ ucfirst($user->role) }}</h3>
					<h3 class="profile-rank">{{ ucwords($user->rank) }}</h3>
				</div>

				<div class="profile-meta-stats">
					<div class="profile-registered profile-meta-block">
						<h5 class="profile-meta-upper">{{ __('Joined ') }}</h4>
						<h4 class="profile-meta-lower">{{ pretty_date($user->created_at) }}</h3>
					</div>
					<div class="profile-likes profile-meta-block">
						<h5 class="profile-meta-upper">{{ __('Post likes') }}</h5>
						<h4 class="profile-meta-lower">{{ count($posts_with_likes) }}</h4>
					</div>
					<div class="profile-posts profile-meta-block">
						<h5 class="profile-meta-upper">{{ __('Posts') }}</h4>
						<h4 class="profile-meta-lower">{{ count($user->posts) }}</h3>
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

		<div class="profile-lower">
			
		</div>
	</div>
@endsection