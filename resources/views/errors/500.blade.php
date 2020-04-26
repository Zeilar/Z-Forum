{{-- Passed variables: $value --}}
@extends('head')

@section('pageTitle')
	500 {{ __('Server error') }}
@endsection

@php $disableSidebar = true; @endphp

@section('content')
	<div class="page-error" id="five-hundred">
		<div class="header">
			<h1>
				<span>5</span>
				<i class="fas fa-cog"></i>
				<i class="fas fa-cog"></i>
			</h1>

			<h2>{{ __('Server error') }}</h2>

			<h4>
				{{ __('We were unable to perform your action, the servers may be busy') }}
				<br>
				{{ __('If the issue persists, please contact an administrator') }}
			</h4>

			<a class="btn btn-success-full" href="{{url()->previous()}}">
				{{ __('Go back') }}
			</a>
		</div>
	</div>
@endsection