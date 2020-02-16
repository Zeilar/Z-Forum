@extends('layouts.head')

@section('content')
	<div id="not-found">
		<div class="header">
			<i class="fas mb-4 fa-ghost"></i>
			<h1 class="color-green">404 Not Found</h1>
		</div>

		<form class="mt-4" action="/search" method="get">
			@csrf
			<div class="search d-flex">
				<input class="py-2" type="text" name="search" id="search" placeholder="What are you looking for?" />
				<button type="submit">
					<i class="fas fa-search"></i>
				</button>
			</div>
		</form>
	</div>
@endsection