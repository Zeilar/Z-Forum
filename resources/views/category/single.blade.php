{{-- Passed variables: $category --}}
@extends('head')

@section('pageTitle')
	{{ $category->title }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('category', $category) }}
@endsection

@section('content')
	@auth
		<button class="btn btn-success-full mark-as-read">{{ __('Mark all threads as read') }}</button>
	@endauth

	<div class="category" id="table">
		<div class="table-group">
			@component('components.table-header')
				@slot('title')
					{{ $category->title }}
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

			@foreach ($category->subcategories as $subcategory)	
				@auth
					{{-- Check if user has any read thread in the subcategory --}}
					@php $read = true @endphp
					@foreach ($subcategory->threads as $thread)
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
					@endforeach
				@endauth

				@component('components.table-row', ['read' => $read ?? null])
					@isset($subcategory->icon)
						@slot('icon')
							{{ $subcategory->icon }}
						@endslot
					@endisset

					@slot('title')
						<a href="{{route('subcategory_show', [$subcategory->id, $subcategory->slug])}}">
							{{ $subcategory->title }}
						</a>
					@endslot

					@slot('views')
						@php $views = 0; @endphp
						@foreach ($subcategory->threads as $thread)
							@php $views += $thread->views @endphp
						@endforeach
						{{ $views }}
					@endslot

					@slot('posts')
						{{ count($subcategory->posts) }}
					@endslot

					@slot('latest_post')
						@foreach ($subcategory->posts()->latest()->get() as $post)
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
			@endforeach {{-- $subcategory --}}
		</div>
	</div>

	@can('create', App\Subcategory::class)
		@component('modals.crud', ['route_name' => 'subcategory_store', 'route_values' => [$category->id, $category->slug], 'icon' => true])
			@slot('title')
				{{ __('Create new subcategory') }}
			@endslot
			@slot('submit')
				{{ __('Create') }}
			@endslot
		@endcomponent

		<a class="btn btn-success-full" id="create-button" data-toggle="modal" href="#crudModal">
			<span>{{ __('Create new subcategory') }}</span>
		</a>
	@endcan

	@auth
		{{-- Which collection to mark as read --}}
		@php $collection = 'category_id' @endphp
		@php $id = $category->id @endphp

		@include('js.mark-as-read')

		<script>
			$('.mark-as-read').click(async function() {
				mark_as_read();
			});
		</script>
	@endauth
@endsection

@can('update', App\Category::class)
    @section('toolbarItem')
        @component('components.toolbar-item', ['cookie' => 'category'])
            @slot('icon')
                <i class="fas fa-tags"></i>
            @endslot

            @slot('categoryTitle')
                {{ __('Category') }}
            @endslot

            @slot('toolbarSubitem')
                @can('update', App\Category::class)
                    @component('components.toolbar-subitem')
                        @slot('subitemTitle')
                            {{ __('Title') }}
                        @endslot

                        @slot('content')
                            <input type="text" id="category-rename" value="{{$category->title}}">
                            <button class="btn btn-success category-rename-submit" disabled>{{ __('Save') }}</button>
                        @endslot
                    @endcomponent
                @endcan

                @can('delete', App\Category::class)
                    @component('components.toolbar-subitem')
                        @slot('subitemTitle')
                            {{ __('Delete category') }}
                        @endslot

                        @slot('formAction')
                            {{ route('category_delete', [$category->id]) }}
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

        @can('update', App\Category::class)
            @include('js.post.alert')

            <script>
                let originalTitle = '{{ $category->title }}';
                $('.category-rename-submit').click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: '{{ route("category_update") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ Session::token() }}',
                            id: '{{ $category->id }}',
                            title: $('#category-rename').val(),
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

                $('#category-rename').on('input change', function() {
                    if ($(this).val() !== '' && $(this).val() !== originalTitle) {
                        $('.category-rename-submit').removeAttr('disabled');
                    } else {
                        $('.category-rename-submit').attr('disabled', true);
                    }
                });
            </script>
        @endcan
    @endsection
@endcan