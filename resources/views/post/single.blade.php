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

	<a class="btn btn-success" href="{{route('post_edit', [$post->id])}}">
		<span>{{ __('Edit') }}</span>
	</a>
	
	<form action="{{route('post_delete', [$post->id])}}" method="post">
		@csrf
		<input type="hidden" name="_method" value="DELETE">
		<button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
	</form>
@endsection