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
						<input type="text" id="register_username" name="username" class="form-control" required>
					</div>
					<div class="form-group">
						<label>{{ __('Email') }}</label>
						<input type="email" id="register_email" name="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label>{{ __('Password') }}</label>
						<input type="password" id="register_password" name="password" class="form-control" required>
					</div>
					<div class="form-group">
						<label>{{ __('Repeat password') }}</label>
						<input type="password" id="register_password_repeat" name="password_confirmation" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">		
					<input type="submit" class="btn btn-block btn-success pull-right" value="{{__('Register')}}">
				</div>
			</form>
		</div>
	</div>
</div> 