{{-- Passed variables: $i --}}
<article class="post" id="{{$post->id}}">
	<div class="post-header">
		<div class="post-meta
			@auth
				@if ($post->user->id === auth()->user()->id)
					is_author
				@elseif ($post->user->id === $post->thread->user->id)
					is_op
				@else
					{{ role_coloring($post->user->role) }}
				@endif
			@else
				@if ($post->user->id === $post->thread->user->id)
					is_op
				@else
					{{ role_coloring($post->user->role) }}
				@endif
			@endauth
		">
			<a class="post-avatar-link" href="{{route('user_show', [$post->user->id])}}">
				<div class="post-avatar @if (is_user_online($post->user->id)) is_online @endif">
					<img class="img-fluid" src="/storage/user-avatars/{{$post->user->avatar}}" alt="{{ __('Post user avatar') }}" />

					<div class="avatar-meta">
						@if (is_user_online($post->user->id)) 
							<p class="status">{{ __('Online') }}</p> 
						@else
							<p class="status">{{ __('Offline') }}</p>
						@endif
						@isset($post->user->last_seen)
							@php $date = new \Carbon\Carbon($post->user->last_seen) @endphp
							<p>{{ $date->diffForHumans() }}</p>
						@endisset
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

	@isset ($post->edited_by)
		<div class="post-edited-by">
			{!! $post->edited_by !!}
		</div>
	@endisset

	@auth
		@can('update', $post)
			<div class="post-toolbar">
				<button class="btn btn-default post-edit">
					<span>{{ __('Edit') }}</span>
				</button>

				@can('delete', $post)
					<button class="btn btn-hazard spin post-delete">
						{{ __('Delete') }}
					</button>
				@endcan
			</div>
		@endcan
	@endauth
</article>