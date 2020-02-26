<nav class="navbar navbar-expand-md">
	<div class="container-fluid" id="navbar-container">
		<a class="navbar-brand" href="{{route('index')}}">
			<img class="img-fluid" src="/images/zforum-logo.png" alt="{{ __('Navigation bar brand logo') }}" />
		</a>
		<i class="fas fa-2x fa-rocket"></i>

		<div id="posts-slider">
			@foreach ($latest_posts as $latest_post)
				<div class="latest-post">
					<a href="{{route('post_show', [$latest_post->thread->id, $latest_post->thread->slug, $latest_post->id])}}">
						{{ $latest_post->thread->title }}
					</a>
				</div>
			@endforeach
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

		<nav class="nav-list">
			@auth
				<img class="nav-avatar img-fluid" src="/storage/user-avatars/{{auth()->user()->avatar}}" alt="{{ __('User avatar') }}" />
				<ul class="nav-items">
					<li class="nav-item">
						<a href="#" class="nav-link">
							1
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							2
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							3
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							4
						</a>
					</li>
				</ul>
			@else
				<ul class="nav-items">
					<li class="nav-item">
						<a class="nav-link" id="login-button" data-toggle="modal" href="#loginModal">{{ __('Login') }}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="modal" href="#registerModal">{{ __('Register') }}</a>
					</li>
				</ul>
			@endauth
		</nav>
	</div>
</nav>

{{-- <!-- Sliding latest posts -->
<div class="m-auto" id="posts-slider">
	@foreach ($latest_posts as $latest_post)
		<div class="latest-post">
			<a href="{{route('post_show', [$latest_post->thread->id, $latest_post->thread->slug, $latest_post->id])}}">
				{{ $latest_post->thread->title }}
			</a>
		</div>
	@endforeach
</div>
<!-- Search form -->
<form action="{{route('search')}}" method="get">
	@csrf
	<div class="nav-search ml-auto mr-3 d-flex">
		<div class="search-wrapper">
			<input class="rounded-left py-1 px-2" type="text" name="search" id="search" placeholder="Search" />
			<i class="fas fa-times"></i>
		</div>
		<button class="rounded-right" type="submit">
			<i class="fas fa-search"></i>
		</button>
	</div>
</form> --}}