@extends('layouts.head')

@section('content')
	@component('components.dashboard', ['superadmin' => true])
		@include('dashboard.settings.superadmin')
	@endcomponent
@endsection