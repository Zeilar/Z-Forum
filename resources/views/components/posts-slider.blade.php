<div id="posts-slider">
	@foreach ($latest_posts as $latest_post)
		<div class="latest-post">
			<a href="{{route('post_show', [$latest_post->thread->id, $latest_post->thread->slug, $latest_post->id])}}">
				{{ $latest_post->thread->title }}
			</a>
		</div>
	@endforeach
</div>