@extends('layouts.head')

@section('content')
	<p class="breadcrumb">
		<a href="/">Home</a> 
		<span class="mx-1">&raquo;</span>
		<a href="
			{{route('tablecategory_show', [$thread->tableSubcategory->tableCategory->title, $thread->tableSubcategory->tableCategory->id])}}
		">{{ $thread->tableSubcategory->tableCategory->title }}</a>
		<span class="mx-1">&raquo;</span>
		<a href="{{route('tablesubcategory_show', [$thread->tableSubcategory->title, $thread->tableSubcategory->id])}}">
			{{ $thread->tableSubcategory->title }}
		</a>
		<span class="mx-1">&raquo;</span>
		<span>{{ $thread->title }}</span>
	</p>

	<div class="thread-title bg-dark mb-3">
		<h5 class="text-white">{{ $thread->title }}</h5>
	</div>

	<div class="thread">
		@foreach ($thread->posts as $post)
			<article class="post <?php if ($thread->user->id === $post->user->id) echo 'is_author'; ?> mb-2" id="post-{{$post->id}}">
				<div class="post-banner row m-0 justify-content-between">
					<span class="post-date px-2 color-white">
						{{ date_comma($post->created_at) }}
					</span>
					<span class="post-permalink px-2">
						<a href="{{route('post_permalink', [$post->id])}}">Permalink</a>
					</span>
				</div>
				<div class="post-content px-2">
					<?= $post->content ?>
				</div>
			</article>
		@endforeach
	</div>
	@if (logged_in())
		<form class="quick-reply" action="{{route('post_store', [$thread->title, $thread->id])}}" method="POST">
			@csrf
			<textarea name="content" id="form-content"></textarea>
			<button class="btn btn-success" type="submit">{{ __('Send') }}</button>
		</form>
		<a href="{{route('post_create', [$thread->title, $thread->id])}}">
			<button class="btn mt-4 btn-success color-white" type="button">{{ __('Reply') }}</button>
		</a>
	@endif

	@if (session('error'))
		<p class="text-white">{{ __(session('error')) }}</p>
	@endif
@endsection