@empty($disableNavbar)
	<nav class="navbar navbar-expand-md">
		<div class="container-fluid" id="navbar-container">
			<a class="navbar-brand" href="{{route('index')}}">
				<img class="img-fluid" src="/storage/images/zforum-logo.png" alt="{{ __('Navigation bar brand logo') }}" />
				<i class="fas fa-2x fa-rocket"></i>
			</a>

			<div class="navbar-content">
				<nav class="nav-list">
					<ul class="nav-items">
						@auth
							<li class="nav-item">
								<a class="nav-link account" href="{{route('dashboard_account')}}">
									<span>{{ __('Account') }}</span>
								</a>
							</li>

							<li class="nav-item">
								<a href="#" class="nav-link">
									<span>{{ __('Messages') }}</span>
								</a>
							</li>
						@else
							<li class="nav-item guest">
								<a class="nav-link btn btn-success" id="register-button" data-toggle="modal" href="#registerModal">
									<span>{{ __('Register') }}</span>	
								</a>
							</li>
							<li class="nav-item guest">
								<a class="nav-link ml-auto" id="login-button" data-toggle="modal" href="#loginModal">
									<span>{{ __('Login') }}</span>
								</a>
							</li>
						@endauth
					</ul>
				</nav>
			</div>

			<form action="{{route('search')}}" method="get">
				<div class="nav-search">
					<input type="text" name="query" id="search" autocomplete="off" required />
					<button class="search-animate" type="submit">
						<i class="fas fa-search"></i>
					</button>
				</div>
			</form>
		</div>
	</nav>
@endempty