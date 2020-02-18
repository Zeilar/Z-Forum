<div id="loginModal" class="modal fade">
	<div class="modal-dialog modal-auth">
		<div class="modal-content">
			<form method="POST" action="{{route('login')}}">
				@csrf
				<div class="modal-header">				
					<h4 class="modal-title">{{ __('Login') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">				
					<div class="form-group">
						<label>{{ __('Username or email') }}</label>
						@if (session('error-id')) <p class="color-red" id="error-id">{{ session('error-id') }}</p> @endif
						<input type="text" id="login_email" name="id" autocomplete="off" 
							class="form-control @if (session('error-id')) is-invalid @endif"
							value="{{ old('username') ?: old('email') }}" required
						/>
					</div>
					<div class="form-group">
						<div class="clearfix">
							<label>{{ __('Password') }}</label>
							@if (session('error-password')) <p class="color-red" id="error-password">{{ session('error-password') }}</p> @endif
						</div>
						<div class="password-row">
							<input type="password" id="login_password" name="password" required
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
					<input type="submit" class="btn rounded btn-block btn-success pull-right" value="{{__('Login')}}">
					<p>
						{{ __('Not a member?') }}
						<a data-toggle="modal" data-dismiss="modal" href="#registerModal">{{ __('Sign up') }}</a>
					</p>
				</div>
			</form>
		</div>
	</div>
</div> 