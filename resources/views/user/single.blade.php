@extends('head')

@section('pageTitle')
	{{ __('User | ') . ($user->username ?? __('Deleted')) }}
@endsection

@section('content')
	@include('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => ''])
@endsection