{{-- Passed variables: $value --}}
@extends('layouts.head')

@section('content')
	<div class="page-error" id="four-zero-five">
		<div class="header">
			<h1>
				<span>4</span>
				<i class="fas fa-ban"></i>
				<span>5</span>
			</h1>

			<h2>{{ __('Unauthorized') }}</h2>

			<a class="btn btn-success" href="{{url()->previous()}}">
				{{ __('Go back') }}
			</a>
		</div>
	</div>
@endsection