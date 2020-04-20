@extends('head')

@section('pageTitle')
	{{ __('User | ') . $user->username }}
@endsection

@section('content')
	@component('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => ''])
		
	@endcomponent
@endsection