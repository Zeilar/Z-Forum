<div class="table-header">
	<div class="table-row-content">
		@isset ($title)
			<div class="table-title __wrapper">
				<h4>{{ $title }}</h4>
			</div>
		@endisset

		<div class="table-views __wrapper" title="{{ __('Views') }}">
			<i class="far fa-eye"></i>
		</div>

		<div class="table-posts __wrapper" title="{{ __('Posts') }}">
			<i class="far fa-comments"></i>
		</div>

		<div class="table-latest-post __wrapper"></div>
	</div>

	@isset($collapsible)
		<button class="category-collapse" type="button" title="{{ __('Toggle') }}">
			<i class="fas fa-angle-double-down"></i>
		</button>
	@endisset
</div>