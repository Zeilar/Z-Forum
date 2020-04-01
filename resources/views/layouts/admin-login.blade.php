@extends('head')

@section('pageTitle')
	{{ __('Log in') }}
@endsection

@php
	$disableMaintenance = true;
	$disableSidebar = true;
	$disableModals = true;
	$disableNavbar = true;
	$disableFooter = true;
@endphp

<style>
	::selection {
		background: rgba(0, 0, 0, 0.85) !important;
		color: rgb(0, 255, 255) !important;
	}

	body {
		background-image: url('/storage/images/admin-login.jpg') !important;
		background-repeat: no-repeat;
		background-size: 100% 100%;
	}
</style>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<div id="admin-login">
	<div class="modal-dialog modal-auth">
		<div class="modal-content">
			<form method="POST" action="{{route('admin_login')}}">
				@csrf
				<div class="modal-header">				
					<h4 class="modal-title">{{ __('Admin login') }}</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>{{ __('Username or email') }}</label>
						@if (session('error-id')) <p style="color: red;" id="error-id">{{ session('error-id') }}</p> @endif
						@error('id') <p style="color: red">{{ $message }}</p> @enderror
						<input type="text" id="login_id" name="id" autocomplete="off" autofocus
							class="form-control @error('id') is-invalid @enderror
							@if (session('error-id')) is-invalid @endif" value="{{old('id')}}"
						/>
					</div>
					<div class="form-group">
						<div class="clearfix">
							<label>{{ __('Password') }}</label>
							@if (session('error-password')) <p style="color: red;" id="error-password">{{ session('error-password') }}</p> @endif
							@error('password') <p style="color: red;">{{ $message }}</p> @enderror
						</div>
						<div class="password-row">
							<input type="password" id="login_password" name="password"
								class="form-control @error('password') is-invalid @enderror @if (session('error-password')) is-invalid @endif" 
							/>
							<button class="password-revealer" type="button">
								<i class="far fa-eye"></i>
							</button>
						</div>
					</div>
					<div class="remember-row d-flex flex-row">
						<label class="checkbox-inline pull-left">
							<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
							<span class="checkmark"></span>
							<span class="remember-me">{{ __('Remember me') }}</span>
						</label>
						<a class="ml-auto" href="{{route('index')}}" class="pull-right">{{ __('Forgot Password?') }}</a>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn spin rounded btn-block btn-success">
						<span>{{__('Login')}}</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('.is-invalid').first().focus();
</script>