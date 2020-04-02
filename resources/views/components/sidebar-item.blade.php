<fieldset class="sidebar-item @isset($class) {{$class}} @endisset">
	<div class="sidebar-border"> {{-- To get a second border in the fieldset element --}}
		<div class="sidebar-legend-fixer"></div> {{-- To fix the legend inconsistency --}}
	</div> 
	
	@isset($legend)
		<legend>{{ $legend }}</legend>
	@endisset

	@isset($content)
		{{ $content }}
	@endisset
</fieldset>