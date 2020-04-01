{{-- Passed variables: $value --}}
@extends('head')

@section('pageTitle')
	403 {{ __('Forbidden') }}
@endsection

@php $disableSidebar = true; @endphp

@section('content')
	<div class="page-error" id="four-zero-three">
		<div class="header">
			<h1>
				<span>4</span>
				<i class="fas fa-ban"></i>
				<span>3</span>
			</h1>

			<h2>{{ __('Forbidden') }}</h2>

			<h4>
				{{ __('Your request to access this resource was denied') }}
				<br>
				{{ __('If you believe to be authorized, please contact an administrator') }}
			</h4>

			<a class="btn btn-success" href="{{url()->previous()}}">
				{{ __('Go back') }}
			</a>
		</div>
	</div>
@endsection