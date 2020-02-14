<nav class="navbar navbar-expand-md">
	<div class="container-fluid" id="navbar-container">
		<a class="navbar-brand" href="{{ route('index') }}">Z-Forum <i class="ml-1 fas fa-rocket"></i></a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
			aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}"
		>
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav mr-auto">
				
			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<!-- Search form -->
				<form action="/search" method="get">
					@csrf
					<div class="nav-search mr-3 d-flex">
						<input class="rounded-left py-1 px-2" type="text" name="search" id="search" placeholder="Search" />
						<button class="rounded-right" type="submit">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</form>

				<!-- Authentication Links -->
				@guest
					<li class="nav-item mr-3">
						<a class="nav-link rounded" href="{{ route('login') }}">{{ __('Login') }}</a>
					</li>
					@if (Route::has('register'))
						<li class="nav-item">
							<a class="nav-link rounded" href="{{ route('register') }}">{{ __('Register') }}</a>
						</li>
					@endif
				@else
					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link rounded dropdown-toggle" 
							href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
						>
							{{ Auth::user()->username }} <span class="caret"></span>
						</a>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{route('dashboard')}}">
								{{ __('Dashboard') }}
							</a>

							<a class="dropdown-item" href="{{ route('logout') }}"
								onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
							>
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
				@endguest
			</ul>
		</div>
	</div>
</nav>