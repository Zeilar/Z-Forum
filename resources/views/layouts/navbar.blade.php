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
				<form action="{{route('search')}}" method="get">
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
						<a class="nav-link rounded" data-toggle="modal" href="#loginModal">{{ __('Login') }}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link rounded" data-toggle="modal" href="#registerModal">{{ __('Register') }}</a>
					</li>
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

							<a class="dropdown-item" href="{{route('logout')}}">
								{{ __('Logout') }}
							</a>
						</div>
					</li>
				@endguest
			</ul>
		</div>
	</div>
</nav>