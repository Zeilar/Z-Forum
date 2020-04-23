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
				@error('title') <p style="color: red;">{{ $message }}</p> @enderror
				<input type="text" name="title" id="message-title" value="{{old('title')}}" />
			</fieldset>

			<fieldset class="message-form-recipient">
				<legend>
					<h4>{{ __('Send to') }}</h4>
				</legend>
				@error('recipient') <p style="color: red;">{{ $message }}</p> @enderror
				<input type="text" name="recipient" id="message-recipient" value="{{old('recipient')}}" />
			</fieldset>

			<fieldset class="message-form-content">
				<legend>
					<h4>{{ __('Message') }}</h4>
				</legend>
				@error('content') <p style="color: red;">{{ $message }}</p> @enderror
				<textarea name="content" id="message-content" rows="20" value="{{old('content')}}" ></textarea>
			</fieldset>
		</div>

		<button class="btn message-send btn-success-full" type="submit">
			{{ __('Send') }}
		</button>
	</form>
@endsection