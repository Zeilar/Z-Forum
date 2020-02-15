<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle', 'Z-Forum')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

	<!-- To grant access to jQuery where not already available -->
	<script
		src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
		crossorigin="anonymous">
  	</script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<!-- Summernote.JS CSS -->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">

	<!-- Any -->
	@yield('head')
</head>
<body>
    <div id="app">
        @include('layouts.navbar')

        <main class="container-fluid py-3" id="content">
			@if (session('error'))
				<!-- Error modal -->
				<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="errorModalLabel">
									{{ __('An error occurred') }}
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								{{ __(session('error')) }}
							</div>
						</div>
					</div>
				</div>
			@elseif (session('success'))
				{{ session('success') }}
			@endif

            @yield('content')
        </main>
    </div>
</body>
</html>