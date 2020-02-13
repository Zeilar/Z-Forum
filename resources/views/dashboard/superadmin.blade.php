@extends('layouts.head')

@section('content')
	@component('components.dashboard')
		@section('dashboard-settings')
			<form action="{{route('search')}}" method="get" id="form">
				<div class="form-group">
					<p>Table categories</p>
					<select class="form-control" id="tableCategory">
						@foreach ($tableCategories as $tableCategory)
							<option data-id="{{$tableCategory->id}}">{{ $tableCategory->title }}</option>
						@endforeach
					</select>
					<input type="text" name="title" id="form-content">

					{!! Form::select( 'name', $options, 'default', array('onchange' => 'doSomething(this)') ) !!}
					
					@component('components.content-value', ['value' => $tableCategory->title])
						
					@endcomponent
				</div>
			</form>
		@endsection
	@endcomponent
@endsection