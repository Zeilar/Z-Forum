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
	<script src="{{ asset('js/styles.js') }}"></script>

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
				<div class="popup">
					<div class="unauthorized error bg-green text-white my-3">
						<i class="fas fa-times close-button color-white"></i>
						<i class="fas mr-2 color-white fa-exclamation-triangle"></i>
						<span>{{ session('error') }}</span>
					</div>
				</div>
			@endif

            @yield('content')
        </main>
    </div>
</body>
</html>