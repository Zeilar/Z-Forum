{{--
Passed variables:

$tableCategories
$tableSubcategories
$threads
$posts
$users
--}}
@extends('layouts.head')

@section('content')
	<div class="d-flex flex-row" id="settings">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
			</li>
			@if (is_role('superadmin'))
				<li class="nav-item">
					<a class="nav-link" id="superadmin-tab" data-toggle="tab" href="#superadmin" 
					role="tab" aria-controls="superadmin" aria-selected="false">
						{{ __('Superadmin') }}
					</a>
				</li>
			@endif
			<li class="nav-item">
				<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
			</li>
		</ul>
		<div class="tab-content" id="dashboard-tabs">
			<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				@include('dashboard.account')
			</div>
			@if (is_role('superadmin'))
				<div class="tab-pane fade" id="superadmin" role="tabpanel" aria-labelledby="profile-tab">
					@include('dashboard.superadmin')
				</div>
			@endif
			<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
				
			</div>
		</div>
	</div>
@endsection