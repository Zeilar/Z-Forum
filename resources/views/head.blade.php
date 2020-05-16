<!doctype html>
<html @isset($_COOKIE['custom-scrollbar']) class="custom-scrollbar" @endisset lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

	<!-- BBCode Parser -->
	<script src="{{ asset('js/bbcode_parser/bbcode-config.js') }}"></script>
	<script src="{{ asset('js/bbcode_parser/bbcode-parser.js') }}"></script>

	<!-- Run the parse on every page load -->
	<script>
		$(document).ready(() => {
			$('.post-body').each(function() {
				let body = $(this);
				parsed = BBCodeParser.process(body.html());
				body.html(parsed);
			});
		});
	</script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.28/moment-timezone-with-data.min.js"></script>

	<script>
		document.cookie = `timezone=${moment.tz.guess()}; path=/`;
	</script>

	<!-- TinyMCE -->
	<script src="https://cdn.tiny.cloud/1/utj040vewi8qd66brcntmyyh8pkmtxrtj12d0hekbgtol9la/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

	<!-- Any -->
	@yield('head')
</head>
<body @if (App\MaintenanceMode::find(1)->enabled) class="maintenance" @endif>
	{{-- Maintenance mode check --}}
	@if (App\MaintenanceMode::find(1)->enabled)
		@cannot('update', App\MaintenanceMode::find(1))
			<div id="maintenance">
                <h1>{{ __('We are in maintenance') }}</h1>
                <h2>{{ __('Surf back at a later date!') }}</h2>
            </div>
			@php return @endphp
		@endcannot
	@endif

    <div id="app">
		{{-- Navbar --}}
		@include('layouts.navbar')

		{{-- Modals --}}
		<div class="modals">
			@guest
				@empty($disableModals)	
					@include('modals.password-reset')
					@include('modals.register')
					@include('modals.login')
				@endempty
			@endguest
			
			@empty($disableModals)
				@include('modals.error')
			@endempty
		</div>

		{{-- Admin toolbar --}}
		@include('layouts.toolbar')

		{{-- Main wrapper --}}
        <main class="container-fluid" id="content">
			{{-- Main content --}}
			<div id="main">
				{{-- Breadcrumbs --}}
				@yield('breadcrumbs')

				{{-- Thread title --}}
				@yield('threadTitle')

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