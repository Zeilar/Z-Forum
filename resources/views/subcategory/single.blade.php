{{-- Passed variables: $subcategory --}}
@extends('head')

@section('pageTitle')
	{{ $subcategory->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('subcategory', $subcategory) }}
@endsection

@section('content')
	@auth
		<button class="btn btn-success-full mark-as-read">{{ __('Mark all threads as read') }}</button>
	@endauth
	
	<div class="subcategory" id="table">
		<div class="table-group">
			@component('components.table-header')
				@slot('title')
					{{ $subcategory->title }}
				@endslot
			@endcomponent

			@auth
				@if (count(auth()->user()->visited_threads))
					@foreach (auth()->user()->visited_threads as $visited_thread)
						@php $visitedThreadsIds[] = $visited_thread->thread->id @endphp
					@endforeach
				@else
					@php $visitedThreadsIds = [] @endphp
				@endif
			@endauth

			@foreach ($threads as $thread)	
				{{-- Check if the thread has any admin post --}}
				@foreach ($thread->posts->sortByDesc('created_at') as $post)
					@if ($post->user->is_role('superadmin'))
						@php $admin_post = $post @endphp
						@break
					@endif
				@endforeach

				@auth
					{{-- Check if user has any read thread in the subcategory --}}
					@php $read = true @endphp
					@if (!in_array($thread->id, $visitedThreadsIds))
						@php $read = false @endphp
					@else
						@php $latest_post = $thread->posts()->latest()->get()->take(1)[0] @endphp
						@php $visited = auth()->user()->visited_threads->where('thread_id', $latest_post->thread->id) @endphp
						@foreach ($visited as $item)
							@if (strtotime($item->updated_at) - strtotime($latest_post->created_at) <= 0)
								@php $read = false @endphp
								@break
							@endif
						@endforeach
					@endif
				@endauth

				@component('components.table-row', ['admin_post' => $admin_post ?? null, 'read' => $read ?? null, 'disableFolderIcon' => true])
					@slot('title')
						<a href="{{route('thread_show', [$thread->id, $thread->slug])}}">
							{{ $thread->title }}
						</a>
                        @isset($admin_post)
                            <a class="orange-post" href="{{
                                route('post_show', [
                                    $thread->id,
                                    $thread->slug,
                                    get_item_page_number($thread->posts->sortBy('created_at'), $admin_post->id, settings_get('posts_per_page')),
                                    $admin_post->id,
                                ])
                            }}">
                                {{ __('Orange post') }}
                            </a>
                        @endisset
					@endslot

					@slot('views')
						@php $views = 0; @endphp
						@php $views += $thread->views @endphp
						{{ $views }}
					@endslot

					@slot('posts')
						{{ count($thread->posts) }}
					@endslot

					@slot('latest_post')
						@foreach ($thread->posts()->latest()->get() as $post)
							@isset($post->thread)
								<a class="posted-at" href="{{
									route('post_show', [
										$post->thread->id,
										$post->thread->slug,
										get_item_page_number($post->thread->posts->sortBy('created_at'), $post->id, settings_get('posts_per_page')),
										$post->id,
									])
								}}">
									{{ pretty_date($post->updated_at) }}
									<i class="fas fa-sign-in-alt"></i>
								</a>
								<p>
									<a class="posted-by {{role_coloring($post->user->role)}}" href="{{route('user_show', [$post->user->id])}}">
										{{ $post->user->username }}
									</a>
								</p>
								@break {{-- Since we're in another loop, make sure we only do this one once no matter what --}}
							@endisset
						@endforeach
					@endslot
				@endcomponent
			@endforeach {{-- $threads --}}
		</div>
	</div>
	
    @can('create', App\Thread::class)
        <a class="btn btn-success-full" href="{{route('thread_create', [$subcategory->id, $subcategory->slug])}}">
            <span>{{ __('Create new thread') }}</span>
        </a>
    @endcan

	@auth
		{{-- Which collection to mark as read --}}
		@php $collection = 'subcategory_id' @endphp
		@php $id = $subcategory->id @endphp

		@include('js.mark-as-read')

		<script>
			$('.mark-as-read').click(async function() {
				mark_as_read();
			});
		</script>
	@endauth
@endsection

@can('update', App\Subcategory::class)
    @section('toolbarItem')
        @component('components.toolbar-item', ['cookie' => 'subcategory'])
            @slot('icon')
                <i class="fas fa-tag"></i>
            @endslot

            @slot('categoryTitle')
                {{ __('Subcategory') }}
            @endslot

            @slot('toolbarSubitem')
                @can('update', App\Subcategory::class)
                    @component('components.toolbar-subitem')
                        @slot('subitemTitle')
                            {{ __('Rename subcategory') }}
                        @endslot

                        @slot('content')
                            <input type="text" id="subcategory-rename" value="{{$subcategory->title}}">
                            <button class="btn btn-success subcategory-rename-submit" disabled>{{ __('Save') }}</button>
                        @endslot
                    @endcomponent
                @endcan

                @can('delete', App\Subcategory::class)
                    @component('components.toolbar-subitem')
                        @slot('subitemTitle')
                            {{ __('Delete subcategory') }}
                        @endslot

                        @slot('formAction')
                            {{ route('subcategory_delete', [$subcategory->id]) }}
                        @endslot

                        @slot('content')
                            <button class="btn btn-hazard" type="submit">
                                <i class="fas mr-2 fa-exclamation-triangle"></i>
                                <span>{{ __('Delete') }}</span>
                            </button>
                        @endslot
                    @endcomponent
                @endcan
            @endslot
        @endcomponent

        @can('update', App\Subcategory::class)
            @include('js.post.alert')

            <script>
                let originalTitle = '{{ $subcategory->title }}';
                $('.subcategory-rename-submit').click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: '{{ route("subcategory_update") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ Session::token() }}',
                            id: '{{ $subcategory->id }}',
                            title: $('#subcategory-rename').val(),
                        },
                        success: function(response) {
                            // Insert the newly edited content into the post
                            $('.table-header .table-title h4').html(response.title);

                            // Edit the active breadcrumb content
                            $('.breadcrumb-item.active').html(response.title);

                            // Edit the current URL state for better UX in case user reloads, otherwise it will go to the old item URL
                            window.history.pushState('', '', response.url);

                            // Dispay the alert message on the top of the page
                            if (response.type != null && response.type !== 'none') ajax_alert(response);

                            $('.categry-rename-submit').attr('disabled', true);

                            originalTitle = response.title;
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });

                $('#subcategory-rename').on('input change', function() {
                    if ($(this).val() !== '' && $(this).val() !== originalTitle) {
                        $('.subcategory-rename-submit').removeAttr('disabled');
                    } else {
                        $('.subcategory-rename-submit').attr('disabled', true);
                    }
                });
            </script>
        @endcan
    @endsection
@endcan