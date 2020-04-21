{{-- Passed variables: $value --}}
@extends('head')

@section('pageTitle')
	405 {{ __('Method not allowed') }}
@endsection

@php $disableSidebar = true; @endphp

@section('content')
	<div class="page-error" id="four-zero-five">
		<div class="header">
			<h1>
				<span>4</span>
				<i class="fas fa-ban"></i>
				<span>5</span>
			</h1>

			<h2>{{ __('Method not allowed') }}</h2>

			<h4>
				{{ __('The request method was not allowed') }}
				<br>
				{{ __('If the issue persists, please contact an administrator') }}
			</h4>

			<a class="btn btn-success-full" href="{{url()->previous()}}">
				{{ __('Go back') }}
			</a>
		</div>
	</div>
@endsection