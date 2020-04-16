<div class="sidebar-item @isset($class) {{$class}} @endisset">
	<div class="sidebar-border"> {{-- To get a second border in the sidebar item element --}} </div> 
	
	@isset($title)
		<h5 class="sidebar-title">
			{{ $title }}
		</h5>
	@endisset

	@isset($content)
		<div class="sidebar-item-content">
			{{ $content }}
		</div>
	@endisset
</div>