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

	<!-- TinyMCE -->
	<script src="https://cdn.tiny.cloud/1/utj040vewi8qd66brcntmyyh8pkmtxrtj12d0hekbgtol9la/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

	<!-- Any -->
	@yield('head')
</head>
<body>
    <div id="app">
		{{-- Modals --}}
		@include('modals.register')
		@include('modals.login')
		@include('modals.error')

		@include('layouts.navbar')
		
        <main class="container-fluid" id="content">
            @yield('content')

			@include('layouts.sidebar')
		</main>
		
		<h2 class="color-white">Online users:</h2>
		@foreach (get_online_users() as $user)
			<p class="color-white">{{ $user->username }}</p>
		@endforeach

		<div id="scroller">
			<i class="fas fa-arrow-up"></i>
		</div>
    </div>
	@include('layouts.footer')
</body>
</html>