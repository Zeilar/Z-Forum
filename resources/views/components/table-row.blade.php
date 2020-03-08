{{-- Passed variables: $section --}}
<div class="table-row @isset ($admin_post) admin-post @endisset">
	<i class="far fa-folder-open folder"></i>

	@isset ($title)
		<div class="tr-title __wrapper">
			<p>{{ $title }}</p>
		</div>
	@endisset

	@isset ($views)
		<div class="tr-views __wrapper">
			<i class="far fa-eye"></i>
			<p>{{ $views }}</p>
		</div>
	@endisset
	
	@isset ($posts)
		<div class="tr-posts __wrapper">
			<i class="far fa-comments"></i>
			<p>{{ $posts }}</p>
		</div>
	@endisset

	@isset ($latest_post)
		<div class="tr-latest-post __wrapper">
			<p>{{ $latest_post }}</p>
		</div>
	@endisset
</div>