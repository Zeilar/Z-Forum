@extends('head')

@section('pageTitle')
	{{ __('Settings') }}
@endsection

@section('content')
	<div id="settings">
		<form action="{{route('dashboard_account_update')}}" method="post" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="_method" value="PUT" />

			<div class="form-group">
				<p>{{ __('Avatar') }}</p>
				@error('user-avatar') <p style="color: red">{{ $message }}</p> @enderror

				<label class="file-upload" for="avatar-upload">
					<i class="fas color-white fa-upload"></i>
					<span>{{ __('Upload file') }}</span>
				</label>
				<input type="file" id="avatar-upload" name="user-avatar" />
			</div>

			<div class="form-group">
				<label>{{ __('Signature') }}</label>
				@error('signature') <p style="color: red">{{ $message }}</p> @enderror
				@php $joke = 'Roses are red violets are blue, unexpected \'{\' on line 32' @endphp
    			<textarea 
					class="form-control" name="signature" autocomplete="off" id="settings-signature"
					placeholder="{{$user->signature ?? $joke}}" value="{{old('signature')}}"><?php
				?></textarea>
			</div>

			<div class="form-group">
				<label>{{ __('Items per page') }}</label>
				@error('items_per_page') <p style="color: red">{{ $message }}</p> @enderror
    			<input type="number" class="form-control" name="items_per_page" min="0" max="50" autocomplete="off"
					value="{{old('items_per_page') ?? settings_get('posts_per_page')}}"
				/>
			</div>

			<div class="form-group">
				<label>{{ __('Email address') }}</label>
				@error('email') <p style="color: red">{{ $message }}</p> @enderror
    			<input type="email" class="form-control" id="settings-email" name="email" placeholder="{{$user->email}}" value="{{old('email')}}">
			</div>

			<div class="form-group">
				<label>{{ __('New Password') }}</label>
				@error('password_new') <p style="color: red">{{ $message }}</p> @enderror
				<div class="password-wrapper">
    				<input type="password" class="form-control" id="settings-pw" name="password_new" autocomplete="off">
					<button class="password-revealer" type="button">
						<i class="far fa-eye"></i>
					</button>
				</div>

				<label>{{ __('Confirm new Password') }}</label>
				@error('password_confirm') <p style="color: red">{{ $message }}</p> @enderror
				<div class="password-wrapper">
    				<input type="password" class="form-control" id="settings-pw-confirm" name="password_confirm" autocomplete="off">
					<button class="password-revealer" type="button">
						<i class="far fa-eye"></i>
					</button>
				</div>
			</div>

			<div class="form-group">
				<label>{{ __('Current Password') }}</label>
				@error('password_current') <p style="color: red">{{ $message }}</p> @enderror

				<div class="password-wrapper">
    				<input type="password" class="form-control" id="settings-pw" name="password_current" autocomplete="off" required>
					<button class="password-revealer" type="button">
						<i class="far fa-eye"></i>
					</button>
				</div>
			</div>

			<button class="btn btn-success-full" type="submit">{{ __('Save changes') }}</button>
		</form>
	</div>
	<script>
		$('.nav-link.account').parent().append('<div class="nav-ruler"></div>');
		$('.nav-link.account').addClass('active');
	</script>
@endsection