@extends('head')

@section('pageTitle')
	{{ __('Send new message') }}
@endsection

@section('content')
	<form action="{{route('message_send')}}" method="post">
		@csrf
		<div class="message-form">
			<fieldset class="message-form-title">
				<legend>
					<h4>{{ __('Subject') }}</h4>
				</legend>
				<input type="text" name="title" id="message-title" value="{{old('title')}}" />
			</fieldset>

			<fieldset class="message-form-content">
				<legend>
					<h4>{{ __('Message') }}</h4>
				</legend>
				<textarea name="content" id="message-content" rows="20" value="{{old('content')}}"></textarea>
			</fieldset>
		</div>

		<button class="btn message-send btn-success-full" type="submit">
			{{ __('Send') }}
		</button>
	</form>
@endsection