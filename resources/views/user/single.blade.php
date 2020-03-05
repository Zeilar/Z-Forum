{{-- Passed variables: $user --}}
@extends('layouts.head')

@section('content')
	<h1>{{ $user->username }}</h1>
@endsection