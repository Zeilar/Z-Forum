{{-- Passed variables: $section --}}
<div class="table-row @isset($admin_post) admin-post @endisset">
	<i class="far fa-folder-open folder"></i>

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
			<p>{{ $latest_post }}</p>
		</div>
	@endisset
</div>