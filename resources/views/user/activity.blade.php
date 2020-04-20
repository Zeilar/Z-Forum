@extends('head')

@section('pageTitle')
	{{ $user->username . ' | ' . __('Activity') }}
@endsection

@section('content')
	@component('components.profile', ['user' => $user, 'posts_with_likes' => $posts_with_likes, 'active' => 'activity'])
		@slot('activities')
			<div class="profile-activity">
				@if ($activities)
					@foreach ($activities as $activity)
						<div class="profile-activity-item">
							@php $performed_on = json_decode($activity->performed_on) @endphp
							@php $target = DB::table($performed_on->table)->where($performed_on->table . '.id', $performed_on->id)->first() @endphp

							@if ($performed_on->table === 'users')
								{{ ucfirst($activity->task) }}
								<a class="{{role_coloring($target->role)}}" href="{{route('user_show', [$target->id])}}">
									{{ $target->username }}
								</a>
								{{ __('user page') }}
							@elseif ($performed_on->table === 'posts')
								@php $post = App\Post::find($performed_on->id) @endphp
								@php $thread = $post->thread @endphp
								{{ __('Replied in') }}
								<a href="{{
									route('post_show', [
										$thread->id,
										$thread->slug,
										get_item_page_number($thread->posts->sortBy('created_at'), $post->id, settings_get('posts_per_page')),
										$post->id,
									])
								}}">
									{{ $thread->title }}
								</a>
							@elseif ($performed_on->table === 'threads')
								@php $thread = App\Thread::find($performed_on->id) @endphp
								{{ ucfirst($activity->task) }}
								{{ 'thread' }}
								<a href="{{route('thread_show', [$thread->id, $thread->slug])}}">
									{{ $thread->title }}
								</a>
							@endif
						</div>
					@endforeach
				@else
					<div class="profile-activity-item">
						{{ __('No activities were found 🤔') }}
					</div>
				@endif
			</div>
		@endslot

		@if ($activities)
			@slot('pagination')
				{{ $activities->links('layouts.pagination') }}
			@endslot
		@endif
	@endcomponent
@endsection