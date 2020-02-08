@extends('layouts.head')

@section('content')
	<div class="post <?php if (logged_in()) if ($post->user->id === auth()->user()->id) echo 'is_author'; ?>" id="post-{{$post->id}}">
		<div class="post-banner row m-0 justify-content-between">
			<span class="post-date px-2 color-white">
				<?php $formatted = explode(' ', $post->created_at); echo $formatted[0] . ', ' . $formatted[1]; ?>
			</span>
		</div>
		<div class="post-content px-2">
			<?php echo $post->content ?>
		</div>
	</div>
@endsection