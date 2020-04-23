@extends('head')

@section('pageTitle')
	{{ __('Messages') }}
@endsection

@section('content')
	<div id="messages">
		@dump(App\UserMessage::where('id', 1)->get()->first()->recipient)
	</div>
@endsection