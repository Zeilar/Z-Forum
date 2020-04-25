@extends('head')

@section('pageTitle')
	{{ __('Settings') }}
@endsection

@section('breadcrumbs')
	{{ Breadcrumbs::render('account') }}
@endsection

@section('content')
	<div id="settings">
		@if (session('success'))
			<p class="flash-success">{{ session('success') }}</p>
		@endif

		<form action="{{route('dashboard_account_update')}}" method="post" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="_method" value="PUT" />

			<div class="form-group">
				<p>{{ __('Avatar') }}</p>
				@error('avatar') <p style="color: red">{{ $message }}</p> @enderror

				<img class="file-upload-preview img-fluid" src="{{$user->avatar}}" alt="{{ __('Profile avatar') }}">

				<label class="file-upload" for="avatar-upload">
					<i class="fas color-white fa-upload"></i>
					<span>{{ __('Upload file') }}</span>
				</label>
				<input type="file" id="avatar-upload" name="avatar" />
			</div>

			<div class="form-group">
				<label>{{ __('Signature') }}</label>
				@error('signature') <p style="color: red">{{ $message }}</p> @enderror
				@php $joke = 'Roses are red violets are blue, unexpected \'{\' on line 32' @endphp
    			<textarea 
					class="form-control @error('signature') is-invalid @enderror"
					name="signature" autocomplete="off" rows="3" id="settings-signature"
					placeholder="{{$user->signature ?? $joke}}" value="{{old('signature')}}"><?php
				?></textarea>
			</div>

			<div class="form-group">
				<label>{{ __('Items per page') }}</label>
				@error('items_per_page') <p style="color: red">{{ $message }}</p> @enderror
    			<input
					type="number" class="form-control @error('items_per_page') is-invalid @enderror"
					name="items_per_page" min="0" max="50" autocomplete="off" id="settings-items_per_page"
					value="{{old('items_per_page') ?? settings_get('posts_per_page')}}"
				/>
			</div>

			<div class="form-group">
				<label>{{ __('Email address') }}</label>
				@error('email') <p style="color: red">{{ $message }}</p> @enderror
    			<input 
					type="email" class="form-control @error('email') is-invalid @enderror"
					id="settings-email" name="email" placeholder="{{$user->email}}" value="{{old('email')}}" 
				/>
			</div>

			<div class="form-group">
				<label>{{ __('New Password') }}</label>
				@error('password') <p style="color: red">{{ $message }}</p> @enderror
				<div class="password-wrapper">
    				<input 
						type="password" class="form-control @error('password') is-invalid @enderror"
						id="settings-pw" name="password" autocomplete="off"
					/>
					<button class="password-revealer" type="button">
						<i class="far fa-eye"></i>
					</button>
				</div>

				<label>{{ __('Confirm new Password') }}</label>
				@error('password_confirmation') <p style="color: red">{{ $message }}</p> @enderror
				<div class="password-wrapper">
    				<input 
						type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
						id="settings-pw-confirmation" name="password_confirmation" autocomplete="off"
					/>
					<button class="password-revealer" type="button">
						<i class="far fa-eye"></i>
					</button>
				</div>
			</div>

			<div class="form-group">
				<label>{{ __('Current Password') }}</label>
				@if(session('password_current')) <p style="color: red">{{ session('password_current') }}</p> @endif

				<div class="password-wrapper">
    				<input
						type="password" class="form-control @if(session('password_current')) is-invalid @endif"
						id="settings-pw" name="password_current" autocomplete="off" required
					/>
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