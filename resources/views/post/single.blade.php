{{-- Passed variables: $post --}}
@extends('layouts.head')

@section('content')
	@component('components.post', ['post' => $post])
		@slot('banner_link')
			<a href="{{route('post_show', [$post->thread->id, $post->thread->slug, $post->id])}}">
				{{ __('View in thread') }} &raquo;
			</a>
		@endslot
	@endcomponent

	<a href="{{route('post_edit', [$post->id])}}">
		<button class="btn btn-success" type="button">{{ __('Edit') }}</button>
	</a>
	
	<form action="{{route('post_delete', [$post->id])}}" method="post">
		@csrf
		<input type="hidden" name="_method" value="DELETE">
		<button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
	</form>
@endsection