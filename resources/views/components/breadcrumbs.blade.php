{{-- Passed variables: Model collection instance --}}
<div class="breadcrumbs rounded mb-3 d-flex flex-row">
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

{{-- 
<div class="breadcrumbs d-flex flex-row">
	<a href="/">{{ __('Home') }}</a> 
	<span class="mx-2"><i class="fas fa-angle-double-right"></i></span>
	<a href="
		{{route('tablecategory_show', [$tableSubcategory->tableCategory->title, $tableSubcategory->tableCategory->id])}}
	">{{ $tableSubcategory->tableCategory->title }}</a>
	<span class="mx-2"><i class="fas fa-angle-double-right"></i></span>
	<span>{{ __($tableSubcategory->title) }}</span> 
</div>
 --}}