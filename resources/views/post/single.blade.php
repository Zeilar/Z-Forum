{{-- Passed variables: $post --}}
@extends('layouts.head')

@section('content')
	{{ Breadcrumbs::render('post', $post) }}

	@component('components.post', ['post' => $post])
		@slot('banner_link')
			<a href="{{route('post_show', [$post->thread->id, $post->thread->slug, $post->id])}}">
				{{ __('View in thread') }} &raquo;
			</a>
		@endslot
	@endcomponent

	@include('js.post.controls')
@endsection