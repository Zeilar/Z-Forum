@extends('head')

@section('pageTitle')
	{{ __('User | ') . $user->username }}
@endsection

@section('content')
	<div class="user-profile">
		<div class="profile-upper">
			<div class="profile-avatar">
				<img src="{{$user->avatar}}" alt="{{ __('User profile avatar') }}">
			</div>
			<div class="profile-meta">
				<div class="profile-registered profile-meta-block">
					<h4>{{ __('Joined ') }}</h4>
					<h3>{{ pretty_date($user->created_at) }}</h3>
				</div>
				<div class="profile-posts profile-meta-block">
					<h4>{{ __('Posts') }}</h4>
					<h3>{{ count($user->posts) }}</h3>
				</div>
				<div class="profile-likes profile-meta-block">
					<h4>{{ __('Post likes') }}</h4>
					<h3>amount</h3>
				</div>
			</div>
		</div>
		<div class="profile-middle">
			<div class="profile-name">
				<p>{{ $user->username }}</p>
				<p class="{{role_coloring($user->role)}}">{{ ucfirst($user->role) }}</p>
			</div>
			<div class="profile-signature">
				@isset($user->signature)
					<p class="signature">{{ $user->signature }}</p>
				@else
					<p class="no-signature">{{ __('User has no signature') }}</p>
				@endisset
			</div>
		</div>
	</div>
@endsection