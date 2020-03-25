<div class="toolbar">
	@isset($items)
		@foreach ($items as $item)
			<div class="toolbar-item">
				{!! $item !!}
			</div>
		@endforeach
	@endisset
</div>