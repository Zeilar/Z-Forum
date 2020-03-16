{{-- Passed variables: $value --}}
@extends('layouts.head')

@section('content')
	<div class="page-error" id="four-zero-five">
		<div class="header">
			<i class="fas mb-4 fa-ghost"></i>
			<h2 class="color-green">{{ '405' }}</h2>
			<h1 class="color-green">{{ __('Unauthorized') }}</h1>
		</div>
	</div>
@endsection