@extends('layouts.app')

@section('content')
	<p class="breadcrumb">
		<a href="/">Home</a> 
		<span class="mx-1">&raquo;</span>
		<a href="
			{{route('tablecategory_show', [$thread->tableSubcategory->tableCategory->title, $thread->tableSubcategory->tableCategory->id])}}
		">{{ $thread->tableSubcategory->tableCategory->title }}</a>
		<span class="mx-1">&raquo;</span>
		<a href="
			{{route('tablesubcategory_show', [$thread->tableSubcategory->title, $thread->tableSubcategory->id])}}
		">{{ $thread->tableSubcategory->title }}</a>
		<span class="mx-1">&raquo;</span>
		<span>{{ $thread->title }}</span>
	</p>

	@foreach ($thread->posts as $post)
		<div class="card" id="post-{{$post->id}}">
			<p>{{ $post->content }}</p>
			<p><a href="{{route('post_show', [$thread->title, $thread->id, $post->id])}}">Visit</a></p>
		</div>
	@endforeach
	<a href="{{route('post_create', [$thread->title, $thread->id])}}">Reply</a>
@endsection