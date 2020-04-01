<fieldset class="sidebar-item @isset($class) {{$class}} @endisset">
	<div class="sidebar-border"></div> {{-- To get a second border in the fieldset element --}}
	@isset($legend)
		<legend>{{ $legend }}</legend>
	@endisset

	@isset($content)
		{{ $content }}
	@endisset
</fieldset>