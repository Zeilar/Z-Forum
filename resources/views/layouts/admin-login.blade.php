@extends('layouts.head')

@php
	$disableMaintenance = true;
	$disableSidebar = true;
	$disableModals = true;
	$disableNavbar = true;
@endphp

<style>
	::selection {
		color: rgb(0, 255, 255) !important;
		background: rgba(0, 0, 0, 0.85) !important;
	}
</style>

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
						@if (session('error-id')) <p class="color-red" id="error-id">{{ session('error-id') }}</p> @endif
						<input type="text" id="login_id" name="id" autocomplete="off"
							class="form-control @if (session('error-id')) is-invalid @endif" value="{{old('id')}}" autofocus
						/>
					</div>
					<div class="form-group">
						<div class="clearfix">
							<label>{{ __('Password') }}</label>
							@if (session('error-password')) <p class="color-red" id="error-password">{{ session('error-password') }}</p> @endif
						</div>
						<div class="password-row">
							<input type="password" id="login_password" name="password"
								class="form-control @if (session('error-password')) is-invalid @endif" 
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