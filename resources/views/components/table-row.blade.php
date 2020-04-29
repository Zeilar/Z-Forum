@php $classes = [] @endphp

@isset ($_COOKIE['fadeTable'])
	@php array_push($classes, 'show') @endphp
@endisset

@isset($admin_post)
	@php array_push($classes, 'admin-post') @endphp
@endisset

@if($read)
	@php array_push($classes, 'read') @endphp
@endif

@php $classes =  join(' ', $classes) @endphp

<div class="table-row {{$classes}}">
	@isset($icon)
		<div class="table-icon">
			<img class="img-fluid" src="/storage/icons/{{$icon}}" />
		</div>
	@endisset

	<div class="table-row-content">
		@empty($disableFolderIcon)
			@if ($read)
				<i class="far fa-folder-open folder"></i>
			@else
				<i class="far fa-folder folder"></i>
			@endif
		@endempty

		@isset($title)
			<div class="table-title __wrapper">
				<p>{{ $title }}</p>
			</div>
		@endisset

		@isset($views)
			<div class="table-views __wrapper">
				<p>{{ $views }}</p>
			</div>
		@endisset
		
		@isset($posts)
			<div class="table-posts __wrapper">
				<p>{{ $posts }}</p>
			</div>
		@endisset

		@isset($latest_post)
			<div class="table-latest-post __wrapper">
				<div class="latest-post">{{ $latest_post }}</div>
			</div>
		@endisset
	</div>
</div>