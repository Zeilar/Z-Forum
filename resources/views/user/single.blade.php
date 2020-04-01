{{-- Passed variables: $user --}}
@extends('head')

@section('pageTitle')
	{{ __('User ') . $user->username }}
@endsection

@section('content')
	<h1>{{ $user->username }}</h1>
@endsection