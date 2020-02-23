{{-- Passed variables: $post --}}
<article class="post<?php if (logged_in()) if ($post->user->id === auth()->user()->id) echo ' is_author'; ?>" id="{{$post->id}}">
	<div class="post-header row m-0 justify-content-between">
		<span class="post-date px-2 color-white">
			{{ __(pretty_date($post->created_at)) }}
		</span>
		<span class="post-thread px-2">
			{{ $banner_link ?? '' }}
		</span>
	</div>
	{{ $thread_title ?? '' }}
	<div class="post-body d-flex flex-row">
		<div class="col p-2 user-meta">
			<p class="user-link">
				<a class="{{ link_role_coloring($post->user->role) }}" href="{{route('user_show', [$post->user->username])}}">
					{{ $post->user->username }}
				</a>
			</p>
			<p class="user-role">{{ __(ucfirst($post->user->role)) }}</p>
			<div class="w-50">
				<img class="img-fluid py-2" src="/storage/{{$post->user->avatar}}" />
			</div>
			<p class="user-date">{{ __('Member since: ' . date('M Y', strtotime($post->user->created_at))) }}</p>
		</div>
		<div class="col p-2 post-content">
			{!! $post->content !!}
		</div>
	</div>
</article>