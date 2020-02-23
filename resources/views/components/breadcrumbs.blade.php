{{-- Passed variables: $position --}}
<div class="breadcrumbs mb-4 d-flex flex-row">
	<a href="{{route('index')}}">{{ __('Home') }}</a>
	<i class="fas mx-2 my-auto fa-angle-double-right"></i>
	@foreach (breadcrumb_guesser($position) as $breadcrumb)
		@if ($breadcrumb['route'])
			<a href="{{$breadcrumb['route']}}">{{ $breadcrumb[0]->title }}</a>
			<i class="fas mx-2 my-auto fa-angle-double-right"></i>
		@else
			{{ $breadcrumb[0]->title }}
		@endif
	@endforeach
</div>