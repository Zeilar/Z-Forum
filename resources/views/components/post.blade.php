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
				@isset($i)
					<span class="post-i">{{ $i }}</span>
				@endisset
				<div class="post-link">
					@isset ($banner_link) 
						{{ $banner_link }}
					@else
						<a href="{{route('post_permalink', [$post->id])}}">
							{{ pretty_date($post->created_at) }}
							<i class="fas fa-link"></i>	
						</a>
					@endisset
				</div>
			</div>
		</div>
	</div>
	<div class="post-body">
		{!! $post->content !!}
	</div>
</article>

	{{-- <div class="post-body d-flex flex-row">
		<div class="col user-meta">
			<p class="user-link">
				<a href="{{route('user_show', [$post->user->username])}}">
					{{ $post->user->username }}
				</a>
			</p>
			<p class="user-role">{{ __(ucfirst($post->user->role)) }}</p>
			<div class="post-avatar w-50">
				<img class="img-fluid" src="/storage/user-avatars/{{$post->user->avatar}}" />
			</div>
			<p class="user-date">{{ __('Registered: ' . date('M Y', strtotime($post->user->created_at))) }}</p>
		</div>
		<div class="post-content">
			{!! $post->content !!}
		</div>
	</div>
	<i class="fas fa-link"></i>
	 --}}