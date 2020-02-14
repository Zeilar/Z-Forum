@extends('layouts.head')

@section('content')
	<div id="not-found">
		<h1 class="not-found color-green">404 Not Found</h1>

		<form action="/search" method="get">
			@csrf
			<div class="search d-flex">
				<input type="text" name="search" id="search" placeholder="What are you looking for?" />
				<button type="submit">
					<i class="fas fa-search"></i>
				</button>
			</div>
		</form>
	</div>
@endsection