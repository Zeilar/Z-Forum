{{-- Passed variables: $value --}}
@extends('layouts.head')

@section('pageTitle')
	500
@endsection

@php $disableSidebar = true; @endphp

@section('content')
	<div class="page-error" id="page-error">
		<div class="header">
			<i class="fas mb-4 fa-ghost"></i>
			<h2 class="color-green">{{ '500' }}</h2>
			<h1 class="color-green">{{ __('Oops, looks like something went wrong on our side') }}</h1>
		</div>
	</div>
@endsection