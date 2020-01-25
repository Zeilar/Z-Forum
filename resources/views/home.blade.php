<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        @extends('layouts.app')

		@section('content')
		<div class="container">
			<div class="row justify-content-center">
				<div class="col">
					<div class="row post">
						1
					</div>
					<div class="row post">
						2
					</div>
					<div class="row post">
						3
					</div>
				</div>
			</div>
		</div>
		@endsection
    </body>
</html>
