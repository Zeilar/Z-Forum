<nav class="navbar navbar-expand-md">
	<div class="container-fluid" id="navbar-container">
		<a class="navbar-brand" href="{{route('index')}}">
			<img class="img-fluid" src="/images/zforum-logo.png" alt="{{ __('Navigation bar brand logo') }}" />
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

						<li class="nav-item">
							<a href="#" class="nav-link">
								<span>{{ __('Test') }}</span>
							</a>
						</li>

						<li class="nav-item">
							<a href="#" class="nav-link">
								<span>{{ __('Test') }}</span>
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
			<img class="nav-avatar img-fluid" src="{{route('user_avatar', [auth()->user()->avatar])}}" alt="{{ __('User avatar') }}" />
		@endauth
	</div>
</nav>

<script>
	$('.nav-link').mouseenter(function() {
		// Spawn nav ruler if it doesn't exist
		if (!$('.nav-ruler').length) $(this).parent().append('<div class="nav-ruler"></div>');

		// Remove any colored nav link and color the latest hovered one
		$('.nav-link.color-white').removeClass('color-white');
		$(this).addClass('color-white');

		// Get index of currently hovered item and the index of the item with the ruler
		let index = $(this).parent().index();
		let rulerIndex = $('.nav-ruler').parents('.nav-item').index();

		// The magic
		let distance = 0;		
		if (rulerIndex - index < 0) {
			for (let i = index; i > rulerIndex; i--) {
				distance += $(`.nav-item:nth-child(${i})`).outerWidth(true);
			}
			$('.nav-ruler').css('transform', `translateX(-${distance}px)`);
		} else {
			for (let i = index; i < rulerIndex; i++) {
				if (index === 0) {
					distance += $(`.nav-item:first-child`).outerWidth(true);
				} else {
					distance += $(`.nav-item:nth-child(${i})`).outerWidth(true);
				}
			}
			$('.nav-ruler').css('transform', `translateX(${distance}px)`);
		}
	});
</script>