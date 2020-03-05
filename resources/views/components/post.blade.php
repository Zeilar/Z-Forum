{{-- Passed variables: $post, $i --}}
<article class="post">
	<div class="post-header">
		<div class="post-meta">
			<div class="post-avatar">
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