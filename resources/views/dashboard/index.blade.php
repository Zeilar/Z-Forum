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
	<div id="settings">
		<ul class="nav nav-tabs" id="dashboard-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="accout-tab" data-toggle="tab" 
					href="#account" role="tab" aria-controls="home" aria-selected="true">
					{{ __('Account') }}
				</a>
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
				<a class="nav-link" id="contact-tab" data-toggle="tab" 
					href="#contact" role="tab" aria-controls="contact" aria-selected="false">
					
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="accout-tab">
				@include('dashboard.account')
			</div>
			@if (is_role('superadmin'))
				<div class="tab-pane fade" id="superadmin" role="tabpanel" aria-labelledby="superadmin-tab">
					@include('dashboard.superadmin')
				</div>
			@endif
			<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
				
			</div>
		</div>
	</div>
@endsection