{{-- Passed variables: $post --}}
<article class="post<?php if (logged_in()) if ($post->user->id === auth()->user()->id) echo ' is_author'; ?>" id="post-{{$post->id}}">
	<div class="post-header row m-0 justify-content-between">
		<span class="post-date px-2 color-white">
			{{ __(pretty_date($post->created_at)) }}
		</span>
		<span class="post-thread px-2">
			<a href="{{route('post_permalink', [$post->id])}}">{{ __('Permalink') }} &raquo;</a>
		</span>
	</div>
	<div class="post-body d-flex flex-row">
		<div class="col px-2 user-meta">
			<p class="user-link">
				<a href="{{route('user_show', [$post->user->username])}}">{{ $post->user->username }}</a>
			</p>
			<p class="user-role">{{ __(ucfirst($post->user->role)) }}</p>
			<p class="user-date">{{ __('Member since: ' . pretty_date($post->user->created_at)) }}</p>
			{{-- TODO: user profile --}}
		</div>
		<div class="col px-2 post-content px-2">
			{!! $post->content !!}
		</div>
	</div>
</article>