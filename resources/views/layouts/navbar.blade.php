<nav class="navbar navbar-expand-md">
	<div class="container-fluid" id="navbar-container">
		<a class="navbar-brand" href="{{route('index')}}">
			<img class="img-fluid" src="/images/zforum-logo.png" alt="{{ __('Navigation bar brand logo') }}" />
			<i class="fas fa-2x fa-rocket"></i>
		</a>

		<div class="navbar-content">
			<nav class="nav-list @guest ml-auto @endguest">
				<ul class="nav-items">
					@auth
						<li class="nav-item">
							<a href="#" class="nav-link">
								3
							</a>
						</li>
					@else
						<li class="nav-item">
							<a class="nav-link btn btn-success" id="register-button" data-toggle="modal" href="#registerModal">
								<span>{{ __('Register') }}</span>	
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link ml-auto" id="login-button" data-toggle="modal" href="#loginModal">{{ __('Login') }}</a>
						</li>
					@endauth
				</ul>
			</nav>
		</div>

		<form action="{{route('search')}}" method="get">
			@csrf
			<div class="nav-search">
				<div class="search-wrapper">
					<input type="text" name="search" id="search" placeholder="{{ __('Search ...') }}" />
				</div>
				<button type="submit">
					<i class="fas fa-search"></i>
				</button>
			</div>
		</form>
		@auth
			<img class="nav-avatar img-fluid" src="/storage/user-avatars/{{auth()->user()->avatar}}" alt="{{ __('User avatar') }}" />
		@endauth
	</div>
</nav>