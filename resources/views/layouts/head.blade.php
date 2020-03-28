<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('pageTitle', 'Z-Forum')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

	<!-- To grant access to jQuery where not already available -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

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
	{{-- Maintenance mode check --}}
	@if (App\MaintenanceMode::find(1)->enabled)
		@cannot('update', App\MaintenanceMode::find(1))
			@include('errors.maintenance')
			@php return @endphp
		@endcannot
	@endif

    <div id="app">
		{{-- Navbar --}}
		@include('layouts.navbar')

		{{-- Modals --}}
		<div class="modals">
			@empty($disableModals)	
				@include('modals.register')
				@include('modals.login')
				@include('modals.error')
			@endempty
		</div>

		{{-- Admin toolbar --}}
		@include('layouts.toolbar')

		<div class="content-upper">
			{{-- Breadcrumbs --}}
			@yield('breadcrumbs')

			{{-- CRUD toolbar --}}
			@yield('crudToolbar')

			{{-- Thread title --}}
			@yield('threadTitle')
		</div>
		
		{{-- Main wrapper --}}
        <main class="container-fluid" id="content">
			{{-- Main content --}}
			<div id="main">
            	@yield('content')
			</div>

			{{-- Right sidebar --}}
			@include('layouts.sidebar')

			{{-- Scroll to top button --}}
			<div id="scroller">
				<i class="fas fa-arrow-up"></i>
			</div>
		</main>
    </div>
	
	{{-- Footer --}}
	@include('layouts.footer')

	@auth
		<script>
			// Push user status every 3 minutes
			setInterval(() => {
				push_user_status();
			}, 1000 * 60 * 3);

			// Push user status
			function push_user_status() {
				$.ajax({
					url: '{{ route("user_push_status") }}',
					method: 'POST',
					data: {
						_token: '{{ Session::token() }}',
						id: '{{ auth()->user()->id }}',
					},
					error: function(error) {
						console.log(error);
					}
				});
			}
		</script>
	@endauth
</body>
</html>