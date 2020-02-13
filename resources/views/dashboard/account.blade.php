@extends('layouts.head')

@section('content')
	@component('components.dashboard', ['account' => true])
		@include('dashboard.settings.account')
	@endcomponent
@endsection