{{-- Passed variables: $value --}}
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
				<input class="py-2" type="text" name="search" id="search" placeholder="What are you looking for?"
					@if (isset($value)) value="{{$value}}" @endif
				/>
				<button type="submit">
					<i class="fas fa-search"></i>
				</button>
			</div>
		</form>

		<iframe class="m-auto pt-5" width="550" height="400" src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ" frameborder="0" 
			allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture">
		</iframe>
	</div>
@endsection