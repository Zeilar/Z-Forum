@extends('layouts.head')

@section('content')
	<article class="post <?php if (logged_in()) if ($post->user->id === auth()->user()->id) echo 'is_author'; ?>" id="{{$post->id}}">
		<div class="post-banner row m-0 justify-content-between">
			<span class="post-date px-2 color-white">
				{{ date_comma($post->created_at) }}
			</span>
			<span class="post-thread px-2">
				<a href="{{route('post_show', [$post->thread->id, $post->thread->slug, $post->id])}}">{{ __('View in thread') }} &raquo;</a>
			</span>
		</div>
		<div class="post-content px-2">
			{!! $post->content !!}
		</div>
	</article>

	<a href="{{route('post_edit', [$post->id])}}">
		<button class="btn btn-success" type="button">{{ __('Edit') }}</button>
	</a>
	
	<form action="{{route('post_delete', [$post->id])}}" method="post">
		@csrf
		<input type="hidden" name="_method" value="DELETE">
		<button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
	</form>
@endsection