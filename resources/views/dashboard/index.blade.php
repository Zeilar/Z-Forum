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
		<nav class="dashboard-nav">
			<ul class="nav-list d-flex flex-row">
				<li class="nav-item">
					@include('dashboard.account')
				</li>
				<li class="nav-item">
					@include('dashboard.superadmin')
				</li>
				<li class="nav-item">
					sss
				</li>
			</ul>
		</nav>
	</div>
@endsection