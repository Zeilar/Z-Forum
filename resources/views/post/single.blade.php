{{-- Passed variables: $post --}}
@extends('head')

@section('pageTitle')
	{{ __('Post by ') . $post->user->username }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('post', $post) }}
@endsection

@section('content')
	@component('components.post', ['post' => $post, 'disableQuoteButton' => true])
		@slot('banner_link')
			<a href="{{
				route('post_show', [
					$post->thread->id,
					$post->thread->slug,
					get_item_page_number($post->thread->posts->sortBy('created_at'), $post->id, settings_get('posts_per_page')),
					$post->id,
				])
			}}">
				{{ __('Context') }}
				<i class="fas fa-sign-in-alt"></i>
			</a>
		@endslot
	@endcomponent

	@include('js.post.controls')
@endsection