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
						<p class="post-author-role {{role_coloring(auth()->user()->role)}}">
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
									<i class="fas fa-copy"></i>
								</a>
								<a class="ml-2" href="#">
									<i class="fas fa-external-link-alt"></i>
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
	<article class="post" id="{{$post->id}}">
		<div class="post-header">
			<div class="post-meta
				@if ($post->user->id === $post->thread->user->id) 
					is_op
				@else
					{{ role_coloring($post->user->role) }}
				@endif
			">
				<a class="post-avatar-wrapper" href="{{route('user_show', [$post->user->id])}}">
					<div class="post-avatar @if (is_user_online($post->user->id)) is_online @endif">
						<img class="img-fluid" src="/storage/user-avatars/{{$post->user->avatar}}" />

						<div class="avatar-meta">
							@if (is_user_online($post->user->id)) 
								<p>{{ __('Online') }}</p> 
							@else
								<p>{{ __('Offline') }}</p> 
							@endif
							<p>{{ __('Posts: ') . count($post->user->posts) }}</p>
						</div>
					</div>
				</a>
					
				<div class="post-meta-text">
					<div class="post-meta-left">
						<p class="post-author">
							<a href="{{route('user_show', [$post->user->id])}}">
								{{ $post->user->username }}
							</a>
						</p>
						<p class="post-author-role">
							{{ __(ucfirst($post->user->role)) }}
						</p>
					</div>
					
					<div class="post-meta-right">
						@isset ($i)
							<span class="post-i">#{{ $i }}</span>
						@endisset

						<div class="post-link">
							@isset ($banner_link) 
								{{ $banner_link }}
							@else
								<a class="permalink" href="{{route('post_permalink', [$post->id])}}">
									{{ pretty_date($post->created_at) }}
									<i class="fas fa-copy"></i>
								</a>
								
								<a class="ml-2" href="{{route('post_permalink', [$post->id])}}" target="_blank">
									<i class="fas fa-external-link-alt"></i>
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

		<div class="post-toolbar">
			<div class="d-flex flex-row">
				@auth
					@if (is_role('superadmin', 'moderator') || $post->user->id === auth()->user()->id)
						<button class="btn post-edit btn-success">
							<span>{{ __('Edit') }}</span>
						</button>
						<button class="btn post-delete btn-danger">
							{{ __('Delete') }}
						</button>
					@endif
				@endauth
			</div>
		</div>
	</article>
@endif