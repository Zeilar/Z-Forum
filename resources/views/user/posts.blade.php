@extends('head')

@section('pageTitle')
	{{ $user->username . ' | ' . __('Posts') }}
@endsection

@section('content')
	@component('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => 'posts'])
		@slot('posts')
			<div class="profile-posts">
				@foreach ($posts as $post)
					@component('components.post', ['post' => $post, 'disablePostToolbar' => true])
						
					@endcomponent
				@endforeach
			</div>
		@endslot

		@slot('pagination')
			{{ $posts->links('layouts.pagination') }}
		@endslot
	@endcomponent
@endsection