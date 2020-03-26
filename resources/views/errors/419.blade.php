{{-- Passed variables: $value --}}
@extends('layouts.head')

@section('pageTitle')
	419 {{ __('Session expired') }}
@endsection

@php $disableSidebar = true; @endphp

@section('content')
	<div class="page-error" id="four-one-nineteen">
		<div class="header">
			<h1>
				<span>419</span>
			</h1>

			<h2>{{ __('Session expired') }}</h2>

			<h4>
				{{ __('Please') }} <a class="refresh" href="{{url()->current()}}">{{ __('refresh') }}</a> {{ __('and try again') }}
				<br>
				{{ __('If the issue persists, please contact an administrator') }}
			</h4>

			<a class="btn btn-success" href="{{url()->previous()}}">
				{{ __('Go back') }}
			</a>
		</div>
	</div>
@endsection