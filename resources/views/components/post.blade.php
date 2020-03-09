{{-- Passed variables: $post, $i --}}
@if ($post === 'preview')
	<article class="post" id="preview">
		<div class="post-header">
			<div class="post-meta">
				<div class="post-avatar">
					<img class="img-fluid" src="/storage/user-avatars/{{auth()->user()->avatar}}" />
				</div>
					
				<div class="post-meta-text is_author {{ role_coloring(auth()->user()->role) }} ">
					<div class="post-meta-left">
						<p class="post-author">
							<a href="{{route('user_show', [auth()->user()->id])}}">
								{{ auth()->user()->username }}
							</a>
						</p>
						<p class="post-author-role {{ role_coloring(auth()->user()->role) }}">
							{{ __(ucfirst(auth()->user()->role)) }}
						</p>
					</div>
					
					<div class="post-meta-right">
						@isset($i)
							<span class="post-i">#{{ $i }}</span>
						@endisset
						<div class="post-link">
							@isset ($banner_link) 
								{{ $banner_link }}
							@else
								<a class="permalink" href="#">
									{{ 'Today, ' . date('H:i') }}
									<i class="fas fa-link"></i>	
								</a>
							@endisset
						</div>
					</div> {{-- .post-meta-text --}}
				</div>
			</div>
		</div> {{-- .post-header --}}
		<div class="post-body">
			
		</div>
	</article>
@else
	<article class="post">
		<div class="post-header">
			<div class="post-meta">
				<div class="post-avatar @if (is_user_online($post->user->id)) is_online @endif">
					<img class="img-fluid" src="/storage/user-avatars/{{$post->user->avatar}}" />
				</div>
					
				<div id="{{$post->id}}" class="post-meta-text
					@if ($post->user->role !== 'user')
						{{ role_coloring($post->user->role) }}
					@elseif (logged_in()) 
						@if ($post->user->id === auth()->user()->id) 
							is_author
						@endif
					@endif
				">
					<div class="post-meta-left">
						<p class="post-author">
							<a href="{{route('user_show', [$post->user->id])}}">
								{{ $post->user->username }}
							</a>
						</p>
						<p class="post-author-role {{ role_coloring($post->user->role) }}">
							{{ __(ucfirst($post->user->role)) }}
						</p>
					</div>
					
					<div class="post-meta-right">
						@isset($i)
							<span class="post-i">#{{ $i }}</span>
						@endisset
						<div class="post-link">
							@isset ($banner_link) 
								{{ $banner_link }}
							@else
								<a class="permalink" href="{{route('post_permalink', [$post->id])}}">
									{{ pretty_date($post->created_at) }}
									<i class="fas fa-link"></i>	
								</a>
							@endisset
						</div>
					</div> {{-- .post-meta-text --}}
				</div>
			</div>
		</div> {{-- .post-header --}}
		<div class="post-body">
			{!! $post->content !!}
		</div>
	</article>
@endif