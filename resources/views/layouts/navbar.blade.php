@empty($disableNavbar)
	<nav class="navbar navbar-expand-md">
		<div class="container-fluid" id="navbar-container">
			<a class="navbar-brand" href="{{route('index')}}">
				<img class="img-fluid" src="/storage/images/zforum-logo.png" alt="{{ __('Navigation bar brand logo') }}" />
			</a>

			<div class="navbar-content">
				<nav class="nav-list">
					<ul class="nav-items">
						@auth
							<li class="nav-item">
								<a class="nav-link account" href="{{route('dashboard_account')}}">
									<span>{{ __('Account') }}</span>
								</a>

								<ul class="navbar-dropdown">
									<li class="navbar-dropdown-item">
										<a class="navbar-dropdown-link" href="{{route('user_show', [auth()->user()->id])}}">
											<span>{{ __('Profile') }}</span>
										</a>
									</li>
									<li class="navbar-dropdown-item">
										<a class="navbar-dropdown-link" href="{{route('logout')}}">
											<span>{{ __('Logout') }}</span>
										</a>
									</li>
								</ul>
							</li>

							<li class="nav-item">
								<a class="nav-link messages" href="{{route('dashboard_messages')}}">
									<span>{{ __('Messages') }}</span>
								</a>

								<ul class="navbar-dropdown">
                                    <li class="navbar-dropdown-item">
                                        <a class="navbar-dropdown-link" href="{{route('message_new')}}">
                                            <span>{{ __('New') }}</span>
                                        </a>
                                    </li>
								</ul>
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

			<div class="navbar-mobile">
				<ul class="navbar-mobile-items">
                    <form action="{{route('search')}}" method="get">
                        <div class="navbar-mobile-item search">
                            <input type="text" name="query" id="mobile-search" required />
                            <button class="mobile-search-button" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="mobile-search-remove" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </form>
					@auth
						<li class="navbar-mobile-item">
							<a class="navbar-mobile-link" href="{{route('user_show', [auth()->user()])}}">{{ __('Profile') }}</a>
						</li>
						<li class="navbar-mobile-item">
							<a class="navbar-mobile-link" href="{{route('dashboard_account')}}">{{ __('Account') }}</a>
						</li>
						<li class="navbar-mobile-item">
							<a class="navbar-mobile-link" href="{{route('dashboard_messages')}}">{{ __('Messages') }}</a>
						</li>
						<li class="navbar-mobile-item">
							<a class="navbar-mobile-link" href="{{route('logout')}}">{{ __('Logout') }}</a>
						</li>
					@else
						<li class="navbar-mobile-item">
							<a class="navbar-mobile-link" data-toggle="modal" href="#loginModal">{{ __('Login') }}</a>
						</li>
						<li class="navbar-mobile-item register">
							<a class="navbar-mobile-link" data-toggle="modal" href="#registerModal">{{ __('Register') }}</a>
						</li>
					@endauth
				</ul>
			</div>
            
            @isset($_COOKIE['sidebarHidden'])
                @php $class = 'btn-default' @endphp
            @else
                @php $class = 'btn-success' @endphp
            @endisset
            <button class="btn toggle-sidebar {{$class}}" type="button">
                {{ __('Sidebar') }}
            </button>

            <button class="navbar-toggler" type="button">
				<div class="toggle-animator">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
			</button>
		</div>
	</nav>
@endempty