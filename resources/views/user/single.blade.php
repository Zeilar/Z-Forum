{{-- Passed variables: $user --}}
@extends('layouts.head')

@section('pageTitle')
	{{ __('User ') . $user->username }}
@endsection

@section('content')
	<h1>{{ $user->username }}</h1>
@endsection