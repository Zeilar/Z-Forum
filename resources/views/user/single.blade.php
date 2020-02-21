{{-- Passed variables: $user --}}
@extends('layouts.head')

@section('content')
	@if (isset($user->username))
		@include('layouts.user-single')
	@else
		<?php $users = $user; ?>
		@foreach ($users as $user)
			<h1>{{ $user->username }}</h1>
		@endforeach
	@endif
@endsection