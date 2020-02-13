<article class="post <?php if (logged_in()) if ($post->user->id === auth()->user()->id) echo 'is_author'; ?>" id="post-{{$post->id}}">
	<div class="post-banner row m-0 justify-content-between">
		<span class="post-date px-2 color-white">
			{{ date_comma($post->created_at) }}
		</span>
		<span class="post-thread px-2">
			<a href="{{route('post_permalink', [$post->id])}}">{{ __('Permalink') }} &raquo;</a>
		</span>
	</div>
	<div class="post-content px-2">
		{!! $post->content !!}
	</div>
</article>