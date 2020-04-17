@extends('head')

@section('pageTitle')
	{{ __('User | ') . $user->username }}
@endsection

@section('content')
	<div class="user-profile">
		<div class="profile-info">
			<div class="profile-avatar">
				<img src="{{$user->avatar}}" alt="{{ __('User profile avatar') }}">
			</div>
			<p class="profile-username">{{ $user->username }}</p>
			<p class="profile-role {{role_coloring($user->role)}}">{{ ucfirst($user->role) }}</p>
		</div>
		<div class="profile-meta">
			<div class="profile-registered">
				<p>{{ __('Joined ') . pretty_date($user->created_at) }}</p>
			</div>
			<div class="profile-posts">
				<p>{{ __('Posts') }}</p>
				<p>{{ count($user->posts) }}</p>
			</div>
			<div class="profile-likes">
				<p>{{ __('Post likes') }}</p>
				<p></p>
			</div>
		</div>
	</div>
@endsection