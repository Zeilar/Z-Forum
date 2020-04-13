@extends('head')

@section('content')
	{{ $results->appends(request()->query())->links('layouts.pagination') }}

	<div class="search-posts">
		<h2 class="search-category">{{ __('Posts') }}</h2>
		@foreach ($results as $result)
			<div class="search-post">
				<h4 class="post-title">
					@dump(DB::table($result->table_name)->where('id', $result->id)->get())
				</h4>
			</div>
		@endforeach
	</div>

	
@endsection