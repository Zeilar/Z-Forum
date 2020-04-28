@extends('head')

@section('pageTitle')
	{{ $user->username . ' | ' . __('Posts') }}
@endsection

@section('content')
	@component('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => 'posts'])
		@slot('posts')
			<div class="profile-lower posts">
				@if (count($posts))	
					@foreach ($posts as $post)
						@component('components.post', [
							'post'				   => $post,
							'disablePostToolbar'   => true,
							'disablePostBanner'    => true,
							'disablePostSignature' => true
						])
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
								<p>{{ pretty_date($post->created_at) }}</p>
							@endslot
						@endcomponent
					@endforeach
				@else
					{{ __('No posts were found 🤔') }}
				@endif
			</div>
		@endslot

		@slot('pagination')
			{{ $posts->links('layouts.pagination') }}
		@endslot
	@endcomponent
@endsection