<div class="table-header">
	@isset ($title)
		<div class="table-title __wrapper">
			<h4>{{ $title }}</h4>
		</div>
	@endisset

	<div class="table-views __wrapper">
		<i class="far fa-eye" data-title="{{ __('Views') }}"></i>
	</div>

	<div class="table-posts __wrapper">
		<i class="far fa-comments" data-title="{{ __('Posts') }}"></i>
	</div>

	<div class="table-latest-post __wrapper"></div>
</div>