@extends('head')

@section('pageTitle')
	{{ ($user->username ?? __('Deleted')) . ' | ' . __('Likes') }}
@endsection

@section('content')
	@component('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => 'likes'])
		@slot('likes')
			<div class="profile-lower likes">
				@if (count($likes))
					@foreach ($likes as $like)
						@php $post = App\Post::find($like->post_id) @endphp
						@component('components.post', [
							'post'				   => $post,
							'disablePostToolbar'   => true,
							'disablePostBanner'    => true,
							'disablePostSignature' => true
						])
						@endcomponent
					@endforeach
				@else
					{{ __('User hasn\'t liked anything yet 👀') }}
				@endif
			</div>
		@endslot

		@slot('pagination')
			{{ $likes->links('layouts.pagination') }}
		@endslot
	@endcomponent
@endsection