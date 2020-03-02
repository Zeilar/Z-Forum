{{-- Passed variables: $post --}}
<article class="post<?php if (logged_in()) if ($post->user->id === auth()->user()->id) echo ' is_author'; ?> mb-4" id="{{$post->id}}">
	<div class="post-header d-flex flex-row justify-content-between {{ role_coloring($post->user->role) }}">
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
				<a href="{{route('user_show', [$post->user->username])}}">
					{{ $post->user->username }}
				</a>
			</p>
			<p class="user-role">{{ __(ucfirst($post->user->role)) }}</p>
			<div class="w-50">
				<img class="img-fluid py-2" src="/storage/{{$post->user->avatar}}" />
			</div>
			<p class="user-date">{{ __('Registered: ' . date('M Y', strtotime($post->user->created_at))) }}</p>
		</div>
		<div class="col p-2 post-content">
			{!! $post->content !!}
		</div>
	</div>
</article>
