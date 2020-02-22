@extends('layouts.head')

@section('content')
	@component('dashboard.nav', ['active' => 'superadmin'])
		
	@endcomponent

	<div id="settings">
		<h1>Superadmin</h1>
	</div>
@endsection