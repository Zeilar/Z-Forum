<div id="registerModal" class="modal fade">
	<div class="modal-dialog modal-auth">
		<div class="modal-content">
			<form method="POST" action="{{route('register')}}">
				@csrf
				<div class="modal-header">				
					<h4 class="modal-title">{{ __('Register') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">				
					<div class="form-group">
						<label>{{ __('Username') }}</label>
						@error('username') <p class="color-red" id="error-username">{{ $message }}</p> @enderror
						<input type="text" id="register_username" name="username" 
							class="form-control @error('username') is-invalid @enderror" autocomplete="off" autofocus
							value="{{old('username')}}" required placeholder="John"
						/>
					</div>
					<div class="form-group">
						<label>{{ __('Email') }}</label>
						@error('email') <p class="color-red" id="error-email">{{ $message }}</p> @enderror
						<input type="email" id="register_email" name="email" 
							class="form-control @error('email') is-invalid @enderror" 
							value="{{old('email')}}" autocomplete="off" required placeholder="john_doe@gmail.com"
						/>
					</div>
					<div class="form-group">
						<label>{{ __('Password') }}</label>
						@error('password') <p class="color-red" id="error-password">{{ $message }}</p> @enderror
						<div class="password-row">
							<input type="password" id="register_password" name="password" required
								class="form-control @error('password') is-invalid @enderror" 	
							/>
							<button class="password-revealer" type="button">
								<i class="far fa-eye"></i>
							</button>
						</div>
					</div>
					<div class="form-group">
						<label>{{ __('Repeat password') }}</label>
						@error('password_confirmation') <p class="color-red" id="error-password-confirmation">{{ $message }}</p> @enderror
						<div class="password-row">
							<input type="password" id="register_password_repeat" name="password_confirmation" required
								class="form-control @error('password_confirmation') is-invalid @enderror" 
							/>
							<button class="password-revealer" type="button">
								<i class="far fa-eye"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="modal-footer">		
					<input type="submit" class="btn rounded btn-block btn-success pull-right" value="{{__('Register')}}">
					<p>
						{{ __('Already a member?') }}
						<a data-toggle="modal" data-dismiss="modal" href="#loginModal">{{ __('Sign in') }}</a>
					</p>
				</div>
			</form>
		</div>
	</div>
</div> 