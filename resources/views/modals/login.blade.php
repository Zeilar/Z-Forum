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
						<input type="text" id="login_email" name="email" class="form-control" required>
					</div>
					<div class="form-group">
						<div class="clearfix">
							<label>{{ __('Password') }}</label>
							<a href="{{route('index')}}" class="pull-right text-muted"><small>{{ __('Forgot?') }}</small></a>
						</div>
						<input type="password" id="login_password" name="password" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<label class="checkbox-inline pull-left">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
						{{ __('Remember me') }}
					</label>
					
					<input type="submit" class="btn btn-success pull-right" value="{{__('Login')}}">
				</div>
			</form>
		</div>
	</div>
</div> 